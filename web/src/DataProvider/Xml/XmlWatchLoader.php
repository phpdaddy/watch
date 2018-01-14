<?php

namespace App\DataProvider\Xml;

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

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $id
     *
     * @return WatchDto|null
     *
     * @throws XmlLoaderException May be thrown on a fatal error, such as
     * XML file containing data of watches
     * could not be loaded or parsed.
     */
    public function loadById(string $id): ?WatchDto
    {
        $serializer = SerializerBuilder::create()->build();
        if (!$xmlData = @file_get_contents($this->container->getParameter('xmlFilePath'))) {
            throw new XmlLoaderException('Error reading file!');
        }
        /**
         * @var WatchDto[] $watches
         */
        $watches = $serializer->deserialize($xmlData, 'array<WatchDTO>', 'xml');
        foreach ($watches as $watch) {
            if ($watch->id == $id) {
                return $watch;
            }
        }
        return null;
    }
}
