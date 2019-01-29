<?php
/**
 * Created by PhpStorm.
 * User: Banji
 * Date: 28/01/2019
 * Time: 23:53
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\SigninType;
use App\Security\AppAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class SigninController extends AbstractController
{
    /**
     * @Route("/signin", name="app_signin")
     */
    public function signin(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $handler, AppAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(SigninType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $user->setRoles(['ROLE_USER']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $handler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );
        }

        return $this->render('signin/signin.html.twig', [
            'signinForm' => $form->createView()
        ]);
    }
}