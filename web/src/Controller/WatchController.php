<?php

namespace App\Controller;

use App\DataProvider\MySql\MySqlWatchLoaderException;
use App\DataProvider\MySql\MySqlWatchLoader;
use App\DataProvider\MySql\MySqlWatchNotFoundException;
use App\DataProvider\Xml\XmlLoaderException;
use App\DataProvider\Xml\XmlWatchLoader;
use App\DataProvider\Xml\XmlWatchNotFoundException;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

class WatchController extends FOSRestController
{
    /**
     * @var MySqlWatchLoader
     */
    private $mySqlWatchLoader;
    /**
     * @var XmlWatchLoader
     */
    private $xmlWatchLoader;

    public function __construct(MySqlWatchLoader $mySqlWatchRepository, XmlWatchLoader $xmlWatchLoader)
    {
        $this->mySqlWatchLoader = $mySqlWatchRepository;
        $this->xmlWatchLoader = $xmlWatchLoader;
    }

    /**
     * @Rest\Get("/watch/{id}", requirements={"id" = "\d+"})
     */
    public function getByIdAction($id)
    {
        if ($this->container->getParameter('dataProvider') == 'xml') {
            try {
                $data = $this->xmlWatchLoader->loadById($id);
                return $this->view($data, Response::HTTP_OK);
            } catch (XmlWatchNotFoundException $e) {
                return $this->view(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
            } catch (XmlLoaderException $e) {
                return $this->view(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            // default - mysql
            try {
                $data = $this->mySqlWatchLoader->loadById($id);
                return $this->view($data, Response::HTTP_OK);
            } catch (MySqlWatchNotFoundException $e) {
                return $this->view(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
            } catch (MySqlWatchLoaderException $e) {
                return $this->view(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
