<?php

namespace App\DataProvider\Cache;

use App\DataProvider\WatchLoader;
use App\Dto\WatchDto;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CacheService implements WatchLoader
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param int $id
     *
     * @return WatchDto|null
     *
     * @throws CacheServiceException May be thrown on a fatal error, such as
     * cache file containing data of watches
     * could not be loaded or parsed.
     */
    public function loadById(int $id): ?WatchDto
    {
        $serializer = SerializerBuilder::create()->build();
        if (!$jsonData = @file_get_contents($this->container->getParameter('cacheFilePath'))) {
            throw new CacheServiceException('Error reading cache file!');
        }

        /**
         * @var WatchDto[] $watches
         */
        $watches = $serializer->deserialize($jsonData, 'array<App\Dto\WatchDto>', 'json');

        foreach ($watches as $watch) {
            if ($watch->id == $id) {
                return $watch;
            }
        }
        return null;
    }

    /**
     * @param WatchDto $watch
     *
     * @throws CacheServiceException May be thrown on a fatal error, such as
     * cache file containing data of watches
     * could not be loaded,parsed or saved.
     */
    public function addWatch(WatchDto $watch): void
    {
        $serializer = SerializerBuilder::create()->build();
        if (!$jsonData = @file_get_contents($this->container->getParameter('cacheFilePath'))) {
            throw new CacheServiceException('Error reading cache file!');
        }

        /**
         * @var WatchDto[] $watches
         */
        $watches = $serializer->deserialize($jsonData, 'array<App\Dto\WatchDto>', 'json');
        $watches[] = $watch;

        $jsonData = $serializer->serialize($watches, 'json');

        if (!@file_put_contents($this->container->getParameter('cacheFilePath'), $jsonData)) {
            throw new CacheServiceException('Error saving cache!');
        }
    }
}
