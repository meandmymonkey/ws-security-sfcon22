<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
final class UserController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly UserRepository $repository
    ) {}

    #[Route(path: '/users', name: 'app_api_users', methods: ['GET'])]
    #[IsGranted('SENIOR_MEMBER')]
    public function list(): JsonResponse
    {
        $users = $this->repository->findAll();

        return JsonResponse::fromJsonString($this->serializer->serialize($users, 'json'));
    }
}