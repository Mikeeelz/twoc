<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route("/login", methods: 'GET')]
    public function login(Request $request): Response
    {
        return $this->render('login.html.twig', [
            'successRegister' => $request->query->has('success-register'),
            'errorRegister' => $request->query->has('error-register'),
            'loginError' => $request->query->has('error-login'),
        ]);
    }
}
