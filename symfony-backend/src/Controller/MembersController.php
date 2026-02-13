<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MembersController extends AbstractController
{
    #[Route('/members', name: 'app_members')]
    public function login(): Response
    {
        return $this->render('members/login.html.twig');
    }
}