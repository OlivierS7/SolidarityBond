<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Subjects;
use App\Form\CommentType;
use App\Form\SubjectType;
use App\Repository\CommentsRepository;
use App\Repository\StatusRepository;
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
    private $subjectsRepository;

    /**
     * @var CommentsRepository
     */
    private $commentsRepository;

    /**
     * @var StatusRepository
     */
    private $StatusRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var StatusRepository
     */
    private $statusRepository;

    public function __construct(SubjectsRepository $subjectsRepository, CommentsRepository $commentsRepository, StatusRepository $statusRepository, EntityManagerInterface $em)
    {
        $this->subjectsRepository = $subjectsRepository;
        $this->commentsRepository = $commentsRepository;
        $this->statusRepository = $statusRepository;
        $this->em = $em;
    }

    /**
     * @Route("/forum", name="forum.index")
     * @return Response
     */
    public function index(): Response
    {
        $subjects = $this->subjectsRepository->findSujects();
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
        $user = $this->getUser();
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
     * @param Request $request
     * @param string $slug
     * @return Response
     */
    public function show(Subjects $subject, Request $request, string $slug): Response
    {
        if ($subject->getSlug() !== $slug) {
            return $this->redirectToRoute('forum.show', [
                'id' => $subject->getId(),
                'slug' => $subject->getSlug()
            ], 301);
        }
        $user = $this->getUser();
        if ($user) {
            $comments = $this->commentsRepository->findComments($subject->getId());
            $comment = new Comments();
            $form = $this->createForm(CommentType::class, $comment);
            $comment->setSubject($subject);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($comment);
                $this->em->flush();
                return $this->redirectToRoute('forum.show', [
                    'id' => $subject->getId(),
                    'slug' => $subject->getSlug()
                ], 301);
            }
            return $this->render('forum/show.html.twig', [
                'current_forum' => 'forum',
                'subject' => $subject,
                'comments' => $comments,
                'form' => $form->createView()
            ]);
        } else {
            $this->addFlash('error', 'Pour ajouter un commentaire, vous devez être connecté !');
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/forum/deleteSubject-{id}", name="forum.deleteSubject", methods="DELETE")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function deleteSubject(Request $request, int $id)
    {
        if ($this->isCsrfTokenValid('delete', $request->get('_token'))) {
            $subject = $this->subjectsRepository->find($id);
            $this->em->remove($subject);
            $this->em->flush();
        }
        return $this->redirectToRoute('forum.index');
    }

    /**
     * @Route("/forum/deleteComment-{id}", name="forum.deleteComment", methods="DELETE")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function deleteComment(Request $request, int $id)
    {
        if ($this->isCsrfTokenValid('delete', $request->get('_token'))) {
            $comment = $this->commentsRepository->find($id);
            $this->em->remove($comment);
            $this->em->flush();
        }
        return $this->redirectToRoute('forum.index');
    }
}