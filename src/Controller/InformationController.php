<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InformationController extends AbstractController {

    /**
     * @Route("/information", name="information")
     * @return Response
     */
    public function render_information() : Response {
      return $this->render('information/information.html.twig');
    }

}