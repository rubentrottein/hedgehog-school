<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class UserController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/profile', name: 'user_profile', methods: ['GET', 'POST'])]
    public function profile () : Response
    {
        $admin_users = $this->userRepository->findAll();
        $user = $this->getUser();
        //$admin_users = "eh ";
        //$user = "sayer";
        $form = $this->createForm(UserType::class);
        $form
            ->add('email', EmailType::class)
            ->add('roles', TextType::class)
            ->add('password', PasswordType::class)
            ->add('username', TextType::class)
            ->add('Envoyer', SubmitType::class)
        ;

        return $this->render('user/profile.html.twig',
            ['form'=>$form->createView(),
            'user' => $user,
            'admin_users' => $admin_users
            ]);
    }
}