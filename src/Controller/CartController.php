<?php

namespace App\Controller;

use App\Form\QuantityType;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController {

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
                    'product' => $productsRepository->find($id),
                    'quantity' => $quantity
                ];
            }

            $total = 0;

            foreach ($cartData as $item) {
                $totalItem = $item['product']->getPrice() * $item['quantity'];
                $total += $totalItem;
            }

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
}