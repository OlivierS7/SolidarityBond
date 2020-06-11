<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CgaController extends AbstractController {

    /**
     * /**
     * @Route("/cga", name="cga")
     * @return Response
     */
    public function index() : Response {
      return $this->render('cga/cga.html.twig');
    }

}