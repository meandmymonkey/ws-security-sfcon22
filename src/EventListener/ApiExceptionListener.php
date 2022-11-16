<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class ApiExceptionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [];
    }
}