<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\AuthentificationType;
use App\Entity\Users;

class AuthentificationController extends AbstractController {

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var UsersRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, UsersRepository $repository, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->repository = $repository;
    }

    /**
     * @Route("/se-connecter", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils) : Response {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('authentification/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/enregistrer", name="register")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function register(Request $request) {
        $user = new Users();
        $form = $this->createForm(AuthentificationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Votre compte a été enregistré avec succès. Vous pouvez vous connecter dès à présent !');
            return $this->redirectToRoute('login');
        }
        return $this->render('authentification/register.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/se-deconnecter", name="logout")
     * @return Response
     */
    public function logout() : Response {
        return $this->render('accueil/accueil.html.twig', [
            'current_accueil' => 'accueil'
        ]);
    }

    /**
     * @Route("/mon-profil", name="account", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function account(Request $request) : Response {
        $user = $this->getUser();
        if ($user) {
            $form = $this->createForm(AuthentificationType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
                $this->em->persist($user);
                $this->em->flush();
                $this->addFlash('success', 'Votre profil a bien été modifié !');
                return $this->redirectToRoute('account');
            }
            return $this->render('authentification/account.htlm.twig', [
                'current_profil' => 'profil',
                'user' => $user,
                'form' => $form->createView()
            ]);
        } else {
            $this->addFlash('error', 'Pour accéder à votre profil, vous devez être connecté !');
            return $this->render('accueil/accueil.html.twig', [
                'current_accueil' => 'accueil'
            ]);
        }
    }

    /**
     * @Route("/mon-profil", name="delete", methods="DELETE")
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request) {
        $user = $this->getUser();
        $this->container->get('security.token_storage')->setToken(null);
        $this->em->remove($user);
        $this->em->flush();
        $this->addFlash('success', 'Votre profil a bien été supprimé !');
        return $this->redirectToRoute('login');
    }

}