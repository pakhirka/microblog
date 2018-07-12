<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BackendController extends Controller
{
    /**
     * @Route("/admin", name="backend_index")
     */
    public function indexAction(): Response
    {
        return $this->render('backend/backend.html.twig');
    }
}
