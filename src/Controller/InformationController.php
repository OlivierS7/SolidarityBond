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
    public function index() : Response
    {
        return $this->render('information/information.html.twig', [
            'current_information' => 'information'
        ]);
    }
}