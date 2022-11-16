<?php

declare(strict_types=1);

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
final class ProfileController extends AbstractController
{
    #[Route(path: '/me', name: 'app_profile', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function displayProfile(#[CurrentUser] UserInterface $user): Response
    {
        return $this->render('profile.html.twig', ['user' => $user]);
    }
}
