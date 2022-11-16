<?php

namespace App\Controller\Web;

use App\Entity\User;
use App\Security\BackupCodeGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

#[AsController]
final class ResetBackupCodesController
{
    #[Route(path: '/reset-backupcodes', name: 'app_reset_backupcodes')]
    public function __invoke(
        BackupCodeGenerator $backupCodeGenerator,
        Security $security,
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        Session $session
    ): Response {
        /** @var User $user */
        $user = $security->getUser();

        $user->updateBackupCodes(iterator_to_array($backupCodeGenerator->newBatch()));
        $entityManager->flush();

        $session->getFlashBag()->add('2fa_reset_backup_codes', true);

        return new RedirectResponse($urlGenerator->generate('app_profile'));
    }
}
