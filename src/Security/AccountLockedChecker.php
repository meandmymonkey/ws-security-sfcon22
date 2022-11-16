<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\Security\Core\Exception\LockedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class AccountLockedChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof Lockable) {
            return;
        }

        if ($user->isLocked()) {
            throw new LockedException();
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        // noop
    }
}