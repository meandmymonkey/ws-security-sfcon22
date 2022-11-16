<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(18);
        UserFactory::createOne([
            'username' => 'jd',
            'email' => 'jane.doe@example.com',
        ]);
    }
}
