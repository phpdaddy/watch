<?php

namespace App\Controller;

use App\DataProvider\MySql\MySqlRepositoryException;
use App\DataProvider\MySql\MySqlWatchRepository;
use App\DataProvider\Xml\XmlLoaderException;
use App\DataProvider\Xml\XmlWatchLoader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/watch")
 */
class WatchController extends Controller
{
    /**
     * @var MySqlWatchRepository
     */
    private $mySqlWatchRepository;
    /**
     * @var XmlWatchLoader
     */
    private $xmlWatchLoader;

    public function __construct(MySqlWatchRepository $mySqlWatchRepository, XmlWatchLoader $xmlWatchLoader)
    {
        $this->mySqlWatchRepository = $mySqlWatchRepository;
        $this->xmlWatchLoader = $xmlWatchLoader;
    }

    /**
     * @Route("/{id}", requirements={"id" = "\d+"}, defaults={"id" = 1})
     */
    public function getByIdAction($id)
    {
        if ($this->container->getParameter('dataProvider') == 'xml') {
            try {
                return $this->xmlWatchLoader->loadByIdFromXml($id);
            } catch (XmlLoaderException $e) {
                return ['error' => $e->getMessage()];
            }
        } else {
            // default - mysql
            try {
                return $this->mySqlWatchRepository->getWatchById($id);
            } catch (MySqlRepositoryException $e) {
                return ['error' => $e->getMessage()];
            }
        }
    }
}
