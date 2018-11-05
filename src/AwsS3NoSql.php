<?php
namespace AwsS3Utils;

class AwsS3NoSQL
{
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    protected function getAdapter(): Adapter
    {
        return $this->adapter;
    }

    public function set(string $key, string $content): int
    {
        // TODO
    }

    public function get(string $key) : string
    {
        // TODO
    }
}
