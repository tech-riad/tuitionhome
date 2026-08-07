<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tutor;
use Illuminate\Support\Facades\Hash;

class ImportTutors extends Command
{
    /**
     * php artisan tutors:import
     * অথবা
     * php artisan tutors:import storage/app/myfile.csv
     */
    protected $signature = 'tutors:import';

    protected $description = 'Import tutors from CSV';

    public function handle()
    {
        $file = base_path('storage/app/tutors.csv');

        if (!file_exists($file)) {
            $this->error("CSV file not found: {$file}");
            return Command::FAILURE;
        }

        $handle = fopen($file, 'r');

        if (!$handle) {
            $this->error("Unable to open CSV.");
            return Command::FAILURE;
        }

        // Skip Header
        fgetcsv($handle);

        $inserted = 0;
        $skipped = 0;

        $duplicatePhone = 0;
        $duplicateEmail = 0;
        $invalidPhone = 0;
        $rowErrors = 0;

        while (($row = fgetcsv($handle)) !== false) {

            try {

                $name   = trim($row[0] ?? '');
                $email  = strtolower(trim($row[1] ?? ''));
                $gender = strtolower(trim($row[2] ?? ''));
                $phone  = trim($row[3] ?? '');

                // Empty phone
                if (empty($phone)) {
                    $invalidPhone++;
                    $skipped++;
                    continue;
                }

                // --------------------
                // Phone Normalize
                // --------------------

                $phone = str_replace('p:', '', $phone);
                $phone = str_replace('+', '', $phone);
                $phone = str_replace(' ', '', $phone);
                $phone = str_replace('-', '', $phone);
                $phone = str_replace(['(', ')'], '', $phone);

                // Keep only digits
                $phone = preg_replace('/[^0-9]/', '', $phone);

                // 8801XXXXXXXXX -> 01XXXXXXXXX
                if (substr($phone, 0, 3) == '880') {
                    $phone = substr($phone, 2);
                }

                // 1892918694 -> 01892918694
                if (preg_match('/^1[3-9][0-9]{8}$/', $phone)) {
                    $phone = '0' . $phone;
                }

                // Invalid phone
                if (!preg_match('/^01[3-9][0-9]{8}$/', $phone)) {
                    $invalidPhone++;
                    $skipped++;

                    $this->warn("Invalid Phone: {$phone}");

                    continue;
                }

                // Duplicate Phone
                if (Tutor::where('phone', $phone)->exists()) {
                    $duplicatePhone++;
                    $skipped++;
                    continue;
                }

                // Duplicate Email
                if (!empty($email) && Tutor::where('email', $email)->exists()) {
                    $duplicateEmail++;
                    $skipped++;
                    continue;
                }

                // Create Tutor
                $tutor = Tutor::create([
                    'name'              => $name,
                    'email'             => $email ?: null,
                    'phone'             => $phone,
                    'password'          => Hash::make('12345678'),
                    'role_id'           => 3,
                    'gender'            => in_array($gender, ['male', 'female']) ? $gender : 'male',
                    'status'            => 1,
                    'is_verified'       => 0,
                    'is_active'         => 1,
                    'phone_varified_at' => now(),
                    'otp'               => rand(1000, 9999),
                    'otp_expiry'        => now()->addMinutes(10),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);

                // Generate Unique ID
                $tutor->get_tutor_unique_id();

                $inserted++;

                if ($inserted % 100 == 0) {
                    $this->info("Imported : {$inserted}");
                }

            } catch (\Throwable $e) {

                $rowErrors++;
                $skipped++;

                $this->error(
                    "Row Error: " . ($row[0] ?? 'Unknown') . " | " . $e->getMessage()
                );
            }
        }

        fclose($handle);

        $totalProcessed = $inserted + $skipped;

        $this->newLine();
        $this->info("=========================================");
        $this->info("          IMPORT COMPLETED");
        $this->info("=========================================");
        $this->info("Total Processed      : {$totalProcessed}");
        $this->info("Total Inserted       : {$inserted}");
        $this->warn("Total Not Inserted   : {$skipped}");
        $this->line("-----------------------------------------");
        $this->warn("Duplicate Phone      : {$duplicatePhone}");
        $this->warn("Duplicate Email      : {$duplicateEmail}");
        $this->warn("Invalid Phone Format : {$invalidPhone}");
        $this->error("Row Errors           : {$rowErrors}");
        $this->info("=========================================");

        return Command::SUCCESS;
    }
}
