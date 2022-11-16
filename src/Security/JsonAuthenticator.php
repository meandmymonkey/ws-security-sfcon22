<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

final class JsonAuthenticator extends AbstractAuthenticator
{
    public function supports(Request $request): ?bool
    {
        // check for json content type
        // check this is post
    }

    public function authenticate(Request $request): Passport
    {
        // extract credentials
        // create & return passport as in form auth, without csrf
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // return null
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // return 401 response
    }
}