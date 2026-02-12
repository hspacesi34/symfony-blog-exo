<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL_USER', fields: ['email_user'])]
#[UniqueEntity(fields: ['email_user'], message: 'There is already an account with this email_user')]
#[ApiResource(
    operations:[
        new GetCollection(
            uriTemplate: '/users',
            normalizationContext: ['groups' => 'user-read']
        ),
        new Get(
            uriTemplate: '/users/{id}',
            normalizationContext: ['groups' => 'user-read']
        ),
        new Post(
            uriTemplate: '/users',
            denormalizationContext: ['groups' => 'user-write'],
            normalizationContext: ['groups' => 'user-read']
        ),
        new Put(
            uriTemplate: '/users/{id}',
            denormalizationContext: ['groups' => 'user-write'],
            normalizationContext: ['groups' => 'user-read']
        ),
        new Delete(
            uriTemplate: '/users/{id}'
        )
    ]
)]
class User extends Entity implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user-read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['user-read', 'user-write'])]
    #[Assert\NotBlank(message: "L'email ne peut pas être vide")]
    private ?string $email_user = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Groups(['user-read'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['user-write'])]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Groups(['user-read', 'user-write'])]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide")]
    private ?string $name_user = null;

    #[ORM\Column(length: 50)]
    #[Groups(['user-read', 'user-write'])]
    #[Assert\NotBlank(message: "Le prénom ne peut pas être vide")]
    private ?string $firstname_user = null;

    #[ORM\Column]
    #[Groups(['user-read'])]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailUser(): ?string
    {
        return $this->email_user;
    }

    public function setEmailUser(string $email_user): static
    {
        $this->email_user = $email_user;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email_user;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getNameUser(): ?string
    {
        return $this->name_user;
    }

    public function setNameUser(string $name_user): static
    {
        $this->name_user = $name_user;

        return $this;
    }

    public function getFirstnameUser(): ?string
    {
        return $this->firstname_user;
    }

    public function setFirstnameUser(string $firstname_user): static
    {
        $this->firstname_user = $firstname_user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
