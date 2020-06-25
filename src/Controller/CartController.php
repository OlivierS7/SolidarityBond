<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Form\PaymentType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController {

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/panier", name="panier")
     * @param SessionInterface $session
     * @param ProductsRepository $productsRepository
     * @return Response
     */
    public function index(SessionInterface $session, ProductsRepository $productsRepository)  {
        $user = $this->getUser();
        if ($user){
            $cart = $session->get('cart', []);
            $cartData = [];
            foreach ($cart as $id => $quantity){
                $cartData[] = [
                    'nbProduct' => $productsRepository->find($id),
                    'quantity' => $quantity
                ];
            }
            $total = 0;
            foreach ($cartData as $item) {
                $totalItem = $item['nbProduct']->getPrice() * $item['quantity'];
                $total += $totalItem;
            }
            $session->set('total', $total);
            $session->set('items', $cartData);
            return $this->render('boutique/panier.html.twig', [
                'items' => $cartData,
                'total' => $total
            ]);
        } else {
            $this->addFlash('error', 'Pour accèder à votre panier, vous devez être connecté !');
            return $this->redirectToRoute('login');
        }

    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     * @param $id
     * @param SessionInterface $session
     * @param Request $request
     * @return RedirectResponse
     */
    public function add($id, SessionInterface $session, Request $request) {
        $user = $this->getUser();
        if ($user) {
            $quantity = $request->get('quantity');
            $cart = $session->get('cart', []);
            if (!empty($cart[$id])) {
                $cart[$id] += $quantity;
            } else {
                $cart[$id] = $quantity;
            }
            $session->set('cart', $cart);
            $session->get('cart');
            return $this->redirectToRoute('boutique.index');
        } else {
            $this->addFlash('error', 'Pour ajouter un produit à votre panier, vous devez être connecté !');
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     * @param $id
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function remove($id, SessionInterface $session) {
        $user = $this->getUser();
        if ($user) {
            $cart = $session->get('cart', []);
            if(!empty($cart[$id])) {
                unset($cart[$id]);
            }
            $session->set('cart', $cart);
            return $this->redirectToRoute("panier");
        } else {
            $this->addFlash('error', 'Pour supprimer un produit à votre panier, vous devez être connecté !');
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/panier/validate", name="cart_validate")
     * @param Request $request
     * @param SessionInterface $session
     * @param Swift_Mailer $mailer
     * @return Response
     * @throws ApiErrorException
     */
    public function validate(Request $request, SessionInterface $session, Swift_Mailer $mailer): Response {
        $total = $session->get('total', 0);
        $items = $session->get('items');
        $order = new Orders();
        $form = $this->createForm(PaymentType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($total > 0) {
                Stripe::setApiKey('sk_test_51GxTBBJsuHyLC9kVIso0mQs9HgizmBEy0lUYMWUfv0dB3RceSFNWAziNYxTKTB4jbhMEBN0E4w78ihNXRYRYqzbj00pH8Yov86');
                PaymentIntent::create([
                    'amount' => $total * 100,
                    'currency' => 'eur',
                    'payment_method_types' => ['card'],
                    'receipt_email' => 'test@test.fr',
                    'description' => "Paiement du panier",
                ]);
                $order->setPrice($total);
                $this->em->persist($order);
                $this->em->flush();
                $message = (new Swift_Message('Nouvelle commande'))
                    ->setFrom('cesisncovid@gmail.com')
                    ->setTo($order->getUser()->getEmail())
                    ->setBody(
                        $this->renderView(
                            'emails/contact.html.twig', [
                                'user' => $order->getUser(),
                                'items' => $items,
                                'total' => $total
                            ]
                        ),
                        'text/html'
                    );
                    $mailer->send($message);
                    $message = (new Swift_Message('Nouvelle commande'))
                        ->setFrom('cesisncovid@gmail.com')
                        ->setTo('cesisncovid@gmail.com')
                        ->setBody(
                            $this->renderView(
                                'emails/contact2.html.twig', [
                                    'user' => $order->getUser(),
                                    'items' => $items,
                                    'total' => $total
                                ]
                            ),
                            'text/html'
                        );
                    $mailer->send($message);
                $session->set('cart', []);
                $this->addFlash('success', 'Paiement effectué avec succès ! Regarder vos mails');
            } else {
                $this->addFlash('error', 'Panier vide, payement impossible !');
            }
            return $this->redirectToRoute('boutique.index');
        } else {
            return $this->render('boutique/payment.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
}