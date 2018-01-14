<?php

namespace App\DataProvider\Xml;

use App\DataProvider\Cache\CacheService;
use App\DataProvider\WatchLoader;
use App\Dto\WatchDto;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

class XmlWatchLoader implements WatchLoader
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var CacheService
     */
    private $cacheService;

    public function __construct(ContainerInterface $container, CacheService $cacheService)
    {
        $this->container = $container;
        $this->cacheService = $cacheService;
    }

    /**
     * @param int $id
     *
     * @return WatchDto|null
     *
     * @throws XmlLoaderException May be thrown on a fatal error, such as
     * XML file containing data of watches
     * could not be loaded or parsed.
     *
     * @throws XmlWatchNotFoundException Is thrown when the watch could
     * not be found in xml, eg. watch with the
     * associated id does not exist.
     */
    public function loadById(int $id): ?WatchDto
    {
        $watch = $this->cacheService->loadById($id);
        if (isset ($watch)) {
            return $watch;
        }

        $serializer = SerializerBuilder::create()->build();
        if (!$xmlData = @file_get_contents($this->container->getParameter('xmlFilePath'))) {
            throw new XmlLoaderException('Error reading file!');
        }

        /**
         * @var WatchDto[] $watches
         */
        $watches = $serializer->deserialize($xmlData, 'array<App\Dto\WatchDto>', 'xml');

        foreach ($watches as $watch) {
            if ($watch->id == $id) {
                $this->cacheService->addWatch($watch);
                return $watch;
            }
        }
        throw new XmlWatchNotFoundException("Watch was not found");
    }
}
