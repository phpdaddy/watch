<?php

namespace App\Tests\Controller;

use App\Controller\WatchController;
use App\DataProvider\MySql\MySqlWatchLoader;
use App\DataProvider\Xml\XmlWatchLoader;
use App\DataProvider\Xml\XmlWatchNotFoundException;
use App\Dto\WatchDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class WatchControllerTest extends TestCase
{
    /**
     * @var Mockery\MockInterface
     */
    private $container;

    /**
     * @var Mockery\MockInterface
     */
    private $mySqlWatchLoader;

    /**
     * @var Mockery\MockInterface
     */
    private $xmlWatchLoader;

    public function setUp()
    {
        $this->container = Mockery::mock(ContainerInterface::class);
        $this->mySqlWatchLoader = Mockery::mock(MySqlWatchLoader::class);
        $this->xmlWatchLoader = Mockery::mock(XmlWatchLoader::class);
    }

    public function testMysql()
    {
        $watchDto = new WatchDto(0, 'watch', 200, 'desc');

        $this->mySqlWatchLoader->shouldReceive('loadById')
            ->with(0)
            ->once()
            ->andReturn($watchDto);

        $this->container->shouldReceive('getParameter')
            ->with('dataProvider')
            ->once()
            ->andReturn('mysql');

        $controller = new WatchController($this->mySqlWatchLoader, $this->xmlWatchLoader);
        $controller->setContainer($this->container);

        $res = $controller->getByIdAction(0);
        $this->assertEquals($res->getData()->id, 0);
    }

    public function testXml()
    {
        $watchDto = new WatchDto(0, 'watch', 200, 'desc');

        $this->xmlWatchLoader->shouldReceive('loadById')
            ->with(0)
            ->once()
            ->andReturn($watchDto);

        $this->container->shouldReceive('getParameter')
            ->with('dataProvider')
            ->once()
            ->andReturn('xml');

        $controller = new WatchController($this->mySqlWatchLoader, $this->xmlWatchLoader);
        $controller->setContainer($this->container);

        $res = $controller->getByIdAction(0);
        $this->assertEquals($res->getData()->id, 0);
    }

    public function testXml_Exception()
    {
        $watchDto = new WatchDto(0, 'watch', 200, 'desc');

        $this->xmlWatchLoader->shouldReceive('loadById')
            ->with(0)
            ->once()
            ->andThrow(new XmlWatchNotFoundException());

        $this->container->shouldReceive('getParameter')
            ->with('dataProvider')
            ->once()
            ->andReturn('xml');

        $controller = new WatchController($this->mySqlWatchLoader, $this->xmlWatchLoader);
        $controller->setContainer($this->container);

        $res = $controller->getByIdAction(0);
        $this->assertEquals($res->getStatusCode(), Response::HTTP_BAD_REQUEST);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}

?>