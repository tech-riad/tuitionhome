<?php

namespace App\Services;

use App\Models\Tutor;
use App\Models\TutorEducation;
use App\Models\TutorPersonalInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TutorSpreadsheetImporter
{
    public function import($filePath, $importId)
    {
        $spreadsheet = IOFactory::load($filePath);
        $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $headers = array_shift($rows);

        if (!$headers) {
            throw new \RuntimeException('The uploaded spreadsheet is empty.');
        }

        $headerMap = [];
        foreach ($headers as $column => $header) {
            $headerMap[strtolower(trim((string) $header))] = $column;
        }

        $get = function (array $row, $header) use ($headerMap) {
            $column = $headerMap[strtolower(trim($header))] ?? null;
            return $column ? trim((string) ($row[$column] ?? '')) : '';
        };

        $stats = [
            'inserted' => 0,
            'skipped' => 0,
            'duplicate_phone' => 0,
            'duplicate_email' => 0,
            'invalid_phone' => 0,
            'row_errors' => 0,
        ];

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;
            if (!count(array_filter($row, function ($value) {
                return trim((string) $value) !== '';
            }))) {
                continue;
            }

            try {
                $name = $get($row, 'Name');
                $email = strtolower($get($row, 'email'));
                $gender = strtolower($get($row, 'gender'));
                $phone = preg_replace('/[^0-9]/', '', $get($row, 'number'));

                if (substr($phone, 0, 3) === '880') {
                    $phone = '0' . substr($phone, 3);
                } elseif (preg_match('/^1[3-9][0-9]{8}$/', $phone)) {
                    $phone = '0' . $phone;
                }

                if (!$name || !preg_match('/^01[3-9][0-9]{8}$/', $phone)) {
                    $stats['invalid_phone']++;
                    $stats['skipped']++;
                    continue;
                }

                if (Tutor::withTrashed()->where('phone', $phone)->exists()) {
                    $stats['duplicate_phone']++;
                    $stats['skipped']++;
                    continue;
                }

                if ($email && Tutor::withTrashed()->where('email', $email)->exists()) {
                    $stats['duplicate_email']++;
                    $stats['skipped']++;
                    continue;
                }

                DB::transaction(function () use ($row, $get, $name, $email, $gender, $phone, &$stats) {
                    $tutor = Tutor::create([
                        'name' => $name,
                        'email' => $email ?: 'import-' . $phone . '@local.invalid',
                        'phone' => $phone,
                        'password' => Hash::make('12345678'),
                        'role_id' => 3,
                        'gender' => in_array($gender, ['male', 'female'], true) ? $gender : 'male',
                        'status' => 1,
                        'is_verified' => 0,
                        'is_active' => 1,
                        'phone_varified_at' => now(),
                        'otp' => (string) random_int(1000, 9999),
                        'otp_expiry' => now()->addMinutes(10),
                    ]);

                    $tutor->get_tutor_unique_id();

                    TutorPersonalInfo::updateOrCreate(
                        ['tutor_id' => $tutor->id],
                        [
                            'country_id' => 1,
                            'city_id' => (int) $get($row, 'City ID') ?: null,
                            'location_id' => (int) $get($row, 'Location Id') ?: null,
                        ]
                    );

                    TutorEducation::updateOrCreate(
                        ['tutor_id' => $tutor->id, 'degree_name' => 'honours'],
                        [
                            'institute_id' => (int) $get($row, 'University id') ?: null,
                            'department_id' => (int) $get($row, 'Department id') ?: null,
                            'department' => $get($row, 'Department') ?: null,
                            'university_type' => $get($row, 'University Type') ?: null,
                        ]
                    );

                    TutorEducation::updateOrCreate(
                        ['tutor_id' => $tutor->id, 'degree_name' => 'ssc'],
                        [
                            'curriculum_id' => (int) $get($row, 'SSC/O level Background') ?: null,
                        ]
                    );

                    $preferredIds = array_values(array_filter(
                        array_map('intval', preg_split('/[,]+/', $get($row, 'Preferred Location Id') ?: '')),
                        function ($id) {
                            return $id > 0;
                        }
                    ));

                    if ($preferredIds) {
                        $tutor->tutor_prefered_locations()->sync($preferredIds);
                    }

                    $stats['inserted']++;
                });
            } catch (\Throwable $e) {
                $stats['row_errors']++;
                $stats['skipped']++;
                Log::error('Tutor spreadsheet import row failed.', [
                    'import_id' => $importId,
                    'row' => $rowNumber,
                    'exception' => $e,
                ]);
            }
        }

        return $stats;
    }
}
