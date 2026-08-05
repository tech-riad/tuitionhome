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
        $skipped  = 0;
        $errors   = 0;

        while (($row = fgetcsv($handle)) !== false) {

            try {

                $name   = trim($row[0] ?? '');
                $email  = strtolower(trim($row[1] ?? ''));
                $gender = strtolower(trim($row[2] ?? ''));
                $phone  = trim($row[3] ?? '');

                // Empty phone
                if (empty($phone)) {
                    $skipped++;
                    continue;
                }

                // --------------------
                // Phone Normalize
                // --------------------

                // Remove p:
                $phone = str_replace('p:', '', $phone);

                // Remove +
                $phone = str_replace('+', '', $phone);

                // Remove spaces
                $phone = str_replace(' ', '', $phone);

                // Remove dash
                $phone = str_replace('-', '', $phone);

                // Remove brackets
                $phone = str_replace(['(', ')'], '', $phone);

                // Keep only digits
                $phone = preg_replace('/[^0-9]/', '', $phone);

                // 8801XXXXXXXXX -> 01XXXXXXXXX
                if (substr($phone, 0, 3) == '880') {
                    $phone = substr($phone, 2);
                }

                // Invalid phone skip
                if (!preg_match('/^01[3-9][0-9]{8}$/', $phone)) {
                    $errors++;
                    $this->warn("Invalid Phone: {$phone}");
                    continue;
                }

                // Duplicate Phone
                if (Tutor::where('phone', $phone)->exists()) {
                    $skipped++;
                    continue;
                }

                // Duplicate Email
                if (!empty($email) && Tutor::where('email', $email)->exists()) {
                    $skipped++;
                    continue;
                }

                // Create Tutor
                $tutor = Tutor::create([
                    'name'        => $name,
                    'email'       => $email ?: null,
                    'phone'       => $phone,
                    'password'    => Hash::make('12345678'),
                    'role_id'     => 2,
                    'gender'      => in_array($gender, ['male', 'female']) ? $gender : 'male',
                    'status'      => 1,
                    'is_verified' => 0,
                    'is_active'   => 1,
                    'phone_varified_at' => now(),
                    'otp'         => rand(1000, 9999),
                    "otp_expiry" => now()->addMinutes(10),
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);

                // Generate Unique ID
                $tutor->get_tutor_unique_id();

                $inserted++;

                if ($inserted % 100 == 0) {
                    $this->info("Imported : {$inserted}");
                }

            } catch (\Throwable $e) {

                $errors++;

                $this->error(
                    "Row Error: " . ($row[0] ?? 'Unknown') . " | " . $e->getMessage()
                );
            }
        }

        fclose($handle);

        $this->newLine();
        $this->info("==================================");
        $this->info("Import Completed");
        $this->info("Inserted : {$inserted}");
        $this->warn("Skipped  : {$skipped}");
        $this->error("Errors   : {$errors}");
        $this->info("==================================");

        return Command::SUCCESS;
    }
}
