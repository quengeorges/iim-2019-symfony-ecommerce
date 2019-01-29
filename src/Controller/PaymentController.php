<?php
/**
 * Created by PhpStorm.
 * User: Banji
 * Date: 29/01/2019
 * Time: 23:55
 */

namespace App\Controller;


use App\Entity\Payment;
use App\Form\PaymentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/bill", name="payment_bill", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Payment();
        $form = $this->createForm(PaymentType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('admin/product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }
}