<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class BoutiqueController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @Route("/boutique", name="boutique.index")
     * @return Response
     */
    public function index() : Response {
        return $this->render('boutique/index.html.twig', [
            'current_boutique' => 'boutique'
        ]);
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
            $slugger = new AsciiSlugger();
            $form = $this->createForm(ProductType::class, $product);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $uploadedFile = $form['image']->getData();
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
                try {
                    $uploadedFile->move(
                        '../public/images/boutique/produit',
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $manager = new ImageManager();
                $manager->make('../public/images/boutique/produit/'.$newFilename)->fit(650,980)->save('../public/images/boutique/produit/'.$newFilename);
                $product->setImage($newFilename);
                $product->setStatus(true);
                $this->em->persist($product);
                $this->em->flush();
                $this->addFlash('success', 'Produit créé avec succès !');
                return $this->redirectToRoute('boutique.index');
            }
            return $this->render('boutique/new.html.twig', [
                'form' => $form->createView()
            ]);
        } else {
            $this->addFlash('error', 'Pour ajouter un sujet de discussion, vous devez être connecté !');
            return $this->redirectToRoute('login');
        }
    }

}