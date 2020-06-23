<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductEditType;
use App\Form\ProductType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class BoutiqueController extends AbstractController {
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ProductsRepository
     */
    private $repository;

    public function __construct(ProductsRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    /**
     * @Route("/boutique", name="boutique.index")
     * @return Response
     */
    public function index() : Response {
        $articles = $this->repository->findAll();
        return $this->render('boutique/index.html.twig', [
            'current_boutique' => 'boutique',
            'articles' => $articles
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
                $manager->make('../public/images/boutique/produit/'.$newFilename)->resize(400,null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('../public/images/boutique/produit/'.$newFilename);
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

    /**
     * @Route("/boutique/deleteProduct/{id}", name="boutique.delete")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function deleteProduct(Request $request, int $id)
    {
        if ($this->isCsrfTokenValid('delete', $request->get('_token'))) {
            $product = $this->repository->find($id);
            $this->em->remove($product);
            $this->em->flush();
        }
        $this->addFlash('success', 'Produit supprimé avec succès !');
        return $this->redirectToRoute('boutique.index');
    }

    /**
     * @Route("/boutique/{slug}-{id}", name="boutique.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Products $product
     * @param string $slug
     * @return Response
     */
    public function show(Products $product, string $slug): Response
    {
        if ($product->getSlug() !== $slug) {
            return $this->redirectToRoute('/boutique/{slug}-{id}', [
                'id' => $product->getId(),
                'slug' => $product->getSlug()
            ], 301);
        };
        return $this->render('boutique/show.html.twig', [
            'current_boutique' => 'boutique',
            'article' => $product
        ]);
    }

    /**
     * @Route("/boutique/edit/{id}", name="boutique.showEdit")
     * @param Products $product
     * @param Request $request
     * @return Response
     */
    public function showEdit(Products $product, Request $request): Response
    {
        $form = $this->createForm(ProductEditType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($product);
            $this->em->flush();
            $this->addFlash('success', 'Produit édité avec succès !');
            return $this->redirectToRoute('boutique.index');
        }
        return $this->render('boutique/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/boutique/edit/{id}", name="boutique.edit")
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request): Response {

        //$product = $this->repository->find($id);

        return $this->render('boutique/index.html.twig');
    }
}