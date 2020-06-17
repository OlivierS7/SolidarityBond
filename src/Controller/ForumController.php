<?php

namespace App\Controller;

use App\Entity\Subjects;
use App\Entity\Users;
use App\Form\SubjectType;
use App\Repository\SubjectsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{

    /**
     * @var SubjectsRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(SubjectsRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/forum", name="forum.index")
     * @return Response
     */
    public function index(): Response
    {
        $subjects = $this->repository->findAll();
        return $this->render('forum/index.html.twig', [
            'current_forum' => 'forum',
            'subjects' => $subjects
        ]);
    }

    /**
     * @Route("forum/create", name="forum.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $user = new Users();
        $user = $user->getFirstName() . ' ' . $user->getLastName();
        if ($user) {
            $subject = new Subjects();
            $form = $this->createForm(SubjectType::class, $subject);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($subject);
                $this->em->flush();
                $this->addFlash('success', 'Sujet créé avec succès !');
                return $this->redirectToRoute('forum.index');
            }
            return $this->render('forum/new.html.twig', [
                'subject' => $subject,
                'form' => $form->createView()
            ]);
        } else {
            $this->addFlash('error', 'Pour ajouter un sujet de discussion, vous devez être connecté !');
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/forum/{slug}-{id}", name="forum.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Subjects $subject
     * @param string $slug
     * @return Response
     */
    public function show(Subjects $subject, string $slug): Response
    {
        if ($subject->getSlug() !== $slug) {
            return $this->redirectToRoute('forum.show', [
                'id' => $subject->getId(),
                'slug' => $subject->getSlug()
            ], 301);
        };
        return $this->render('forum/show.html.twig', [
            'current_forum' => 'forum',
            'subject' => $subject
        ]);
    }
}