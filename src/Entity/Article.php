<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    operations:[
        new GetCollection(
            uriTemplate: '/articles',
            normalizationContext: ['groups' => ['article-read', 'category-read', 'user-read']]
        ),
        new Get(
            uriTemplate: '/articles/{id}',
            normalizationContext: ['groups' => ['article-read', 'category-read', 'user-read']]
        ),
        new Post(
            uriTemplate: '/articles',
            denormalizationContext: ['groups' => 'article-write', 'allow_extra_attributes' => false],
            normalizationContext: ['groups' => 'article-read']
        ),
        new Put(
            uriTemplate: '/articles/{id}',
            denormalizationContext: ['groups' => 'article-write', 'allow_extra_attributes' => false],
            normalizationContext: ['groups' => 'article-read']
        ),
        new Delete(
            uriTemplate: '/articles/{id}'
        )
    ]
)]
class Article extends Entity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['article-read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le titre ne peut pas être vide')]
    #[Groups(['article-read', 'article-write'])]
    private ?string $title_article = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Le contenu ne peut pas être vide')]
    #[Groups(['article-read', 'article-write'])]
    private ?string $content_article = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'image url ne peut pas être vide")]
    #[Groups(['article-read', 'article-write'])]
    private ?string $image_article = null;

    #[ORM\Column]
    #[Groups(['article-read', 'article-write'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['article-read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['article-read'])]
    private ?\DateTimeImmutable $publishedAt = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[Groups(['article-read', 'article-write'])]
    private ?User $writeBy = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'articles', cascade: ['persist'])]
    #[Groups(['article-read', 'article-write'])]
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleArticle(): ?string
    {
        return $this->title_article;
    }

    public function setTitleArticle(string $title_article): static
    {
        $this->title_article = $title_article;

        return $this;
    }

    public function getContentArticle(): ?string
    {
        return $this->content_article;
    }

    public function setContentArticle(string $content_article): static
    {
        $this->content_article = $content_article;

        return $this;
    }

    public function getImageArticle(): ?string
    {
        return $this->image_article;
    }

    public function setImageArticle(string $image_article): static
    {
        $this->image_article = $image_article;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getWriteBy(): ?User
    {
        return $this->writeBy;
    }

    public function setWriteBy(?User $writeBy): static
    {
        $this->writeBy = $writeBy;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
