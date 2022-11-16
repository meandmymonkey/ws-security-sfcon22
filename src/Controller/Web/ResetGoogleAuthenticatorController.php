<?php

namespace App\Controller\Web;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

#[AsController]
final class ResetGoogleAuthenticatorController
{
    #[Route(path: '/reset-authenticator', name: 'app_reset_google_authenticator')]
    public function __invoke(
        GoogleAuthenticatorInterface $googleAuthenticator,
        Security $security,
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        Session $session
    ): Response {
        /** @var User $user */
        $user = $security->getUser();

        $user->setGoogleAuthenticatorSecret($googleAuthenticator->generateSecret());
        $entityManager->flush();

        $session->getFlashBag()->add('2fa_reset_google_authenticator', true);

        return new RedirectResponse($urlGenerator->generate('app_profile'));
    }
}
