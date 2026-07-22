<?php

namespace App\Services;

use Aws\S3\S3Client;

class CloudflareR2Service
{
    private $client;
    private $bucket;

    public function __construct()
    {
        $this->bucket = config('services.r2.bucket');

        $this->client = new S3Client([
            'version' => 'latest',
            'region' => 'auto',
            'endpoint' => config('services.r2.endpoint'),
            'use_path_style_endpoint' => false,
            'credentials' => [
                'key' => config('services.r2.key'),
                'secret' => config('services.r2.secret'),
            ],
        ]);
    }

    public function upload($file, $path)
    {
        $this->client->putObject([
            'Bucket'      => $this->bucket,
            'Key'         => $path,
            'Body'        => fopen($file->getRealPath(), 'rb'),
            'ContentType' => $file->getMimeType(),
        ]);

        return $path;
    }

    public function delete($path)
    {
        $this->client->deleteObject([
            'Bucket' => $this->bucket,
            'Key'    => $path,
        ]);
    }

    public function url($path)
    {
        $base = config('services.r2.public_url');

        if ($base) {
            return rtrim($base, '/').'/'.$path;
        }

        return null;
    }

    public function getTemporaryUrl($key, $minutes = 30)
    {
        $cmd = $this->client->getCommand('GetObject', [
            'Bucket' => $this->bucket,
            'Key'    => $key,
        ]);

        $request = $this->client->createPresignedRequest(
            $cmd,
            '+' . $minutes . ' minutes'
        );

        return (string) $request->getUri();
    }

    public function getObject($key)
    {
        return $this->client->getObject([
            'Bucket' => $this->bucket,
            'Key'    => $key,
        ]);
    }
}
