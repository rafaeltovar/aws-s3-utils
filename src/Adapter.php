<?php
namespace AwsS3Utils;

use Aws\Result,
    Aws\S3\Exception\DeleteMultipleObjectsException,
    Aws\S3\Exception\S3Exception,
    Aws\S3\Exception\S3MultipartUploadException,
    Aws\S3\S3Client;

class Adapter
{
    protected $client;
    protected $bucket;
    protected $prefix;
    protected $options;

    public function __construct(S3Client $client, string $bucket, string $prefix = '', array $options = [])
    {
        $this->client = $client;
        $this->bucket = $bucket;
        $this->prefix = $prefix;
        $this->options = $options;
    }

    public function getClient(): S3Client
    {
        return $this->client;
    }

    public function getBucket(): string
    {
        return $this->bucket;
    }

    public function applyPrefix($path): string
    {
        return ltrim(sprintf("%s%s", $this->prefix, $path), "/");
    }

    public function getOptions(array $options = []): array
    {
        return array_merge(
                $this->options,
                ['Bucket' => $this->getBucket()],
                $options
            );
    }
}
