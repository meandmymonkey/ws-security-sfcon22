<?php

declare(strict_types=1);

namespace App\Security;

interface Lockable
{
    public function isLocked(): bool;
}