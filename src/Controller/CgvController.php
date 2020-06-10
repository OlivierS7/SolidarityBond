<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CgvController extends AbstractController {

    /**
     * /**
     * @Route("/cgv", name="cgv")
     * @return Response
     */
    public function index() : Response {
      return $this->render('cgv/cgv.html.twig');
    }

}