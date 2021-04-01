<?php

declare(strict_types=1);

namespace Hzx\Elasticsearch;

use Elasticsearch\ClientBuilder;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Guzzle\RingPHP\CoroutineHandler;
use Hyperf\Guzzle\RingPHP\PoolHandler;
use Hyperf\Logger\LoggerFactory;
use Psr\Container\ContainerInterface;
use Hyperf\Contract\ConfigInterface;
use Swoole\Coroutine;
use Elasticsearch\Client;

class ElasticsearchFactory
{

    /**
     * @Inject()
     * @var ConfigInterface
     */
    private $configInterface;

    /**
     * @Inject()
     * @var ContainerInterface
     */
    private $containerInterface;

    /**
     * @return Client
     */
    public function builder(): Builder
    {
        $config = $this->configInterface->get('elasticsearch');

        $clientConfig = $config['client'];
        $loggerConfig = $config['logger'];

        if (!isset($clientConfig['handler']) and Coroutine::getCid() > 0) {
            $handler = $config['pool']['enabled']
                ? make(PoolHandler::class, [
                    'option' => $config['pool'],
                ])
                : make(CoroutineHandler::class);
            $clientConfig['handler'] = $handler;
        }
        if (!isset($clientConfig['logger']) and $loggerConfig['enabled']) {
            $logger = $this->containerInterface->get(LoggerFactory::class)->get($loggerConfig['name'], $loggerConfig['group']);
            $clientConfig['logger'] = $logger;
        }

        return new Builder(
            new Query(new Grammar(), ClientBuilder::fromConfig($clientConfig))
        );
    }
}
