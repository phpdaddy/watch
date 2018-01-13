<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/watch")
 */
class WatchController extends Controller
{
    /**
     * @Route("/{id}", requirements={"id" = "\d+"}, defaults={"id" = 1})
     */
    public function getByIdAction($id)
    {

    }
}
