<?php

declare(strict_types=1);

namespace Hzx\Elasticsearch;

use Elasticsearch\Client;
use Hyperf\Config\Annotation\Value;
use Psr\Log\LoggerInterface;
use Hyperf\Elasticsearch\ClientBuilderFactory;
use Hyperf\Di\Annotation\Inject;

class ElasticsearchFactory
{

    /**
     * @Value("elasticsearch.hosts")
     * @var string
     */
    protected $hosts;

    /**
     * @Inject()
     * @var ClientBuilderFactory
     */
    private $ClientBuilderFactory;

    /**
     * @param array $config
     * @param LoggerInterface|null $logger
     *
     * @return Builder
     */
    public function builder(array $config = []): Builder
    {
        return new Builder(
            new Query(new Grammar(), $this->clientBuilder($config))
        );
    }

    /**
     * @param array $config
     * @param LoggerInterface|null $logger
     *
     * @return Client
     */
    protected function clientBuilder(array $config, ?LoggerInterface $logger = null): Client
    {

        $clientBuilder = $this->ClientBuilderFactory->create();
        if (!empty($config)) {
            $clientBuilder->setHosts($config['hosts']);
        } else {
            $clientBuilder->setHosts([$this->hosts]);
        }

        return $clientBuilder->build();
    }
}
