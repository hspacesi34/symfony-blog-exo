<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[UniqueEntity(fields: ['name_cat'], message: 'Cette catégorie existe déjà')]
#[ApiResource(
    operations:[
        new GetCollection(
            uriTemplate: '/categories',
            normalizationContext: ['groups' => 'category-read']
        ),
        new Get(
            uriTemplate: '/categories/{id}',
            normalizationContext: ['groups' => 'category-read']
        ),
        new Post(
            uriTemplate: '/categories',
            denormalizationContext: ['groups' => 'category-write', 'allow_extra_attributes' => false],
            normalizationContext: ['groups' => 'category-read']
        ),
        new Put(
            uriTemplate: '/categories/{id}',
            denormalizationContext: ['groups' => 'category-write', 'allow_extra_attributes' => false],
            normalizationContext: ['groups' => 'category-read']
        ),
        new Delete(
            uriTemplate: '/categories/{id}'
        )
    ]
)]
class Category extends Entity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category-read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\NotBlank(message: 'Le nom ne peut pas être vide')]
    #[Assert\Length(min: 3, max: 50, minMessage: 'Min 3 caractères', maxMessage: 'Max 50 caractères')]
    #[Groups(['category-read', 'category-write'])]
    private ?string $name_cat = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'La description ne peut pas être vide')]
    #[Groups(['category-read', 'category-write'])]
    private ?string $description_cat = null;

    /**
     * @var Collection<int, Article>
     */
    #[ORM\ManyToMany(targetEntity: Article::class, mappedBy: 'categories')]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameCat(): ?string
    {
        return $this->name_cat;
    }

    public function setNameCat(string $name_cat): static
    {
        $this->name_cat = $name_cat;

        return $this;
    }

    public function getDescriptionCat(): ?string
    {
        return $this->description_cat;
    }

    public function setDescriptionCat(string $description_cat): static
    {
        $this->description_cat = $description_cat;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->addCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            $article->removeCategory($this);
        }

        return $this;
    }
}
