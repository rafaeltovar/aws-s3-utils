<?php
namespace AwsS3Utils;

class AwsS3NoSQL
{
    protected $adapter;
    protected $options;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;

        $this->options = [
            'ACL' => 'private',
            'ContentType'  => 'text/plain',
            'Metadata'     => []
        ];
    }

    protected function getAdapter(): Adapter
    {
        return $this->adapter;
    }

    public function set(string $key, string $content, array $options = []): int
    {
        $default = [
            'ACL' => 'private',
            'ContentType'  => 'text/plain',
            'Metadata'     => [],
            'Body' => $content,
            'Key' => $this->getAdapter()->applyPrefix($key)
        ];

        $options = $this->getAdapter()
                        ->getOptions(array_merge($default, $options));

        $this->getAdapter()->getClient()->putObject($options);
    }

    public function get(string $key) : string
    {
        $options = $this->getAdapter()
                        ->getOptions(['Key' => $this->getAdapter()->applyPrefix($key)]);

        $result = $this->getAdapter()
                       ->getClient()
                       ->getObject($options);

        return $result['Body'];
    }

    public function exists(string $key):bool
    {
        return $this->getAdapter()
                    ->getClient()
                    ->doesObjectExist(
                        $this->getAdapter()->getBucket(),
                        $this->getAdapter()->applyPrefix($key)
                    );
    }

    public function del(string $key)
    {
        $options = $this->getAdapter()
                        ->getOptions(['Key' => $this->getAdapter()->applyPrefix($key)]);

        return $this->getAdapter()
                    ->getClient()
                    ->deleteObject($options);
    }
}
