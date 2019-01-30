<?php
/**
 * Created by PhpStorm.
 * User: Banji
 * Date: 29/01/2019
 * Time: 23:55
 */

namespace App\Controller;


use App\Entity\CartProduct;
use App\Entity\Payment;
use App\Entity\Product;
use App\Form\PaymentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/bill", name="payment_bill", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session): Response
    {
        $payement = new Payment();
        $form = $this->createForm(PaymentType::class, $payement);
        $form->handleRequest($request);

        $cartId = $session->get('cart');
        $repositoryP = $this->getDoctrine()->getRepository(CartProduct::class);
        $all = $repositoryP->findBy(['cart' => $cartId]);
        $products    = array();

        for($i = 0; $i < sizeof($all); $i++) {
            array_push($products, $all[$i]->getProduct());
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($payement);
            $entityManager->flush();

            return $this->redirectToRoute('empty');
        }

        return $this->render('checkout/payment.html.twig', [
            'form' => $form->createView(),
            'products' => $products
        ]);
    }
}