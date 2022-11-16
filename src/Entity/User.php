<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Scheb\TwoFactorBundle\Model\BackupCodeInterface;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface as EmailTwoFactorInterface;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface as GoogleTwoFactorInterface;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, EmailTwoFactorInterface, GoogleTwoFactorInterface, BackupCodeInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Serializer\Ignore]
    private Uuid $id;

    #[ORM\Column(type: 'string', unique: true)]
    private string $username;

    #[ORM\Column(type: 'string')]
    private string $email;

    #[ORM\Column(type: 'string')]
    #[Serializer\Ignore]
    private string $password;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Serializer\Ignore]
    private ?string $emailAuthCode = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Serializer\Ignore]
    private ?string $googleAuthenticatorSecret = null;

    #[ORM\Column(type: 'simple_array', nullable: true)]
    #[Serializer\Ignore]
    private array $backupCodes = [];

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    public function __construct(string $username, string $email, string $password, DateTimeImmutable|null $createdAt = null)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt ?? new DateTimeImmutable();
    }

    public function getDisplayName(): string
    {
        return sprintf('%s (%s)', $this->getUsername(), $this->getEmail());
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
        // noop
    }

    #[Serializer\Ignore]
    public function getUserIdentifier(): string
    {
        return $this->getUsername();
    }

    #[Serializer\Ignore]
    public function isEmailAuthEnabled(): bool
    {
        return true;
    }

    #[Serializer\Ignore]
    public function getEmailAuthRecipient(): string
    {
        return $this->getEmail();
    }

    public function getEmailAuthCode(): ?string
    {
        return $this->emailAuthCode;
    }

    public function setEmailAuthCode(string $authCode): void
    {
        $this->emailAuthCode = $authCode;
    }

    #[Serializer\Ignore]
    public function isGoogleAuthenticatorEnabled(): bool
    {
        return null !== $this->getGoogleAuthenticatorSecret();
    }

    #[Serializer\Ignore]
    public function getGoogleAuthenticatorUsername(): string
    {
        return $this->getEmail();
    }

    public function getGoogleAuthenticatorSecret(): ?string
    {
        return $this->googleAuthenticatorSecret;
    }

    public function setGoogleAuthenticatorSecret(string $secret): void
    {
        $this->googleAuthenticatorSecret = $secret;
    }

    #[Serializer\Ignore]
    public function getBackupCodes(): array
    {
        return $this->backupCodes;
    }

    #[Serializer\Ignore]
    public function isBackupCode(string $code): bool
    {
        return in_array($code, $this->backupCodes);
    }

    public function invalidateBackupCode(string $code): void
    {
        $this->backupCodes = array_filter(
            $this->backupCodes,
            fn (string $value) => $value !== $code
        );
    }

    public function updateBackupCodes(array $codes): void
    {
        $this->backupCodes = $codes;
    }
}
