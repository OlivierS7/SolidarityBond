<?php

namespace App\Controller;

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

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
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
    public function index() : Response {
        return $this->render('accueil/accueil.html.twig', [
            'current_accueil' => 'accueil'
        ]);
    }

}