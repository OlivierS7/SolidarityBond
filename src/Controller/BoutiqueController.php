<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController {
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/boutique", name="boutique.index")
     * @return Response
     */
    public function index() : Response {
        return $this->render('boutique/index.html.twig');
    }

    /**
     * @Route("/boutique/create", name="boutique.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request) : Response {
        $user = $this->getUser();
        if ($user) {
            $product = new Products();
            $form = $this->createForm(ProductType::class, $product);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($product);
                $this->em->flush();
                $this->addFlash('success', 'Produit créé avec succès !');
                return $this->redirectToRoute('boutique.index');
            }
            return $this->render('boutique/new.html.twig', [
                'form' => $form->createView()
            ]);
        } else {
            $this->addFlash('error', 'Pour ajouter un produit, vous devez être connecté !');
            return $this->redirectToRoute('login');
        }

    }

}