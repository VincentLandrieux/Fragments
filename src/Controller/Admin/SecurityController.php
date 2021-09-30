<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class SecurityController extends AbstractController
{

    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin/security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    public function create(UserPasswordHasherInterface $encoder, Request $request): Response
    {
        // create new product
        $admin = new Admin();

        // create form product
        $form = $this->createFormBuilder($admin, array('csrf_protection' => false))
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->getForm();

        // if form post recieved
        if ($request->isMethod('POST') && $this->isCsrfTokenValid('create', $request->get('_token'))) {

            $form->submit([
                'username' => $request->get('_username'),
                'password' => $request->get('_password')
            ]);

            if ($form->isSubmitted() && $form->isValid()) {
                // hash password
                $admin->setPassword($encoder->hashPassword($admin, $admin->getPassword()));

                // save entity
                $em = $this->getDoctrine()->getManager();
                $em->persist($admin);
                $em->flush();

                $this->addFlash('success', 'Nouveau admin créé');

                // redirect to index page
                return $this->redirectToRoute('admin.product.index');
            }
        }

        // serve edit page
        return $this->render('admin/security/create.html.twig');
    }
}
