<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index()
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    /**
     * @Route("/cart.json", name="cart_json", methods={"GET"})
     */
    public function cartJSON()
    {
        $cart = [
            'products' => [
                'id'    => 1,
                'quantity' => 2
            ]
        ];
        return new JsonResponse($cart);
    }

    /**
     * @Route("/cart/add.json", name="add_cart_json", methods={"POST"})
     */
    public function addToCart(Request $request)
    {
        $repositoryP = $this->getDoctrine()->getRepository((Product::class));
        $product = $repositoryP->find($request->request->get('product_id'));

        if (!$product instanceof Product)
        {
            $status = 'ko';
            $message = 'PRODUCT NOT FOUND';
        }else{
            if ($product->getStock() < $request->get('quantity')){
                $status = 'Ok';
                $message = 'MISSING QUANTITY FOR PRODUCT';
            }else{
                $status = 'Ok';
                $message = 'ADDED TO CART';
            }

        }
        dd($request->request);
        return new JsonResponse([
            'result' => $status,
            'message' => $message
        ]);
    }
}
