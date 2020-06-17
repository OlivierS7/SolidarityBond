<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController {

    /**
     * @Route("/conditions-generales-d-achat", name="cga")
     * @return Response
     */
    public function render_cga() : Response {
      return $this->render('mentionsLegales/cga.html.twig');
    }

    /**
     * @Route("/conditions-generales-de-vente", name="cgv")
     * @return Response
     */
    public function render_cgv() : Response {
        return $this->render('mentionsLegales/cgv.html.twig');
    }

    /**
     * @Route("/conditions-generales-d-utilisation", name="cgu")
     * @return Response
     */
    public function render_cgu() : Response {
        return $this->render('mentionsLegales/cgu.html.twig');
    }

}