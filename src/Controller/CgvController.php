<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CgvController extends AbstractController {

    /**
     * @Route("/conditions-generales-de-vente", name="cgv")
     * @return Response
     */
    public function index() : Response {
        return $this->render('mentionsLegales/cgv.html.twig');
    }

}