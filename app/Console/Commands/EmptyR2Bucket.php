<?php

namespace App\Console\Commands;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Illuminate\Console\Command;

class EmptyR2Bucket extends Command
{
    protected $signature = 'r2:empty';

    protected $description = 'Delete all objects from Cloudflare R2 bucket';

    public function handle()
    {
        $bucket = env('R2_BUCKET');

        if (!$bucket) {
            $this->error('R2_BUCKET is not configured.');
            return Command::FAILURE;
        }

        $client = new S3Client([
            'version' => 'latest',
            'region' => 'auto',
            'endpoint' => env('R2_ENDPOINT'),
            'use_path_style_endpoint' => false,
            'credentials' => [
                'key' => env('R2_ACCESS_KEY'),
                'secret' => env('R2_SECRET_KEY'),
            ],
        ]);

        $deleted = 0;

        $this->info("Emptying bucket: {$bucket}");

        while (true) {

            try {

                $result = $client->listObjectsV2([
                    'Bucket' => $bucket,
                    'MaxKeys' => 100,
                ]);

            } catch (AwsException $e) {

                $this->error($e->getAwsErrorMessage() ?: $e->getMessage());
                return Command::FAILURE;
            }

            if (empty($result['Contents'])) {
                break;
            }

            $objects = [];

            foreach ($result['Contents'] as $object) {
                $objects[] = [
                    'Key' => $object['Key'],
                ];
            }

            $retry = true;

            while ($retry) {

                try {

                    $client->deleteObjects([
                        'Bucket' => $bucket,
                        'Delete' => [
                            'Objects' => $objects,
                            'Quiet' => true,
                        ],
                    ]);

                    $retry = false;

                } catch (AwsException $e) {

                    $status = $e->getStatusCode();

                    if ($status == 429) {

                        $this->warn('Rate limited. Waiting 5 seconds...');

                        sleep(5);

                        continue;
                    }

                    $this->error($e->getAwsErrorMessage() ?: $e->getMessage());

                    return Command::FAILURE;
                }
            }

            $deleted += count($objects);

            $this->info("Deleted: {$deleted}");

            usleep(300000); // 0.3 sec pause
        }

        $this->info("Bucket is empty. Total deleted: {$deleted}");

        return Command::SUCCESS;
    }
}
