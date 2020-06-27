<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatController extends AbstractController {

    /**
     * @Route("/stat", name="stat")
     * @return Response
     */
    public function index() : Response
    {
        return $this->render('information/stat.html.twig', [
            'current_stat' => 'stat'
        ]);
    }
}