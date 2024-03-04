<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_post = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'auteur ne peut pas être vide")]
    private ?string $author = null;

    #[ORM\Column(length: 255)]
  #[Assert\NotBlank(message: "Le titre ne peut pas être vide")]
    #[Assert\Length(max: 255, maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères")]
    private ?string $title = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "La date de création ne peut pas être vide")]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le nombre de vues ne peut pas être vide")]
    #[Assert\Type(type: "integer", message: "Le nombre de vues doit être un entier")]
    private ?int $views_count = null;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Comment::class)]
    private Collection $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getIdPost(): ?int
    {
        return $this->id_post;
    }

    public function setIdPost(int $id_post): static
    {
        $this->id_post = $id_post;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getViewsCount(): ?int
    {
        return $this->views_count;
    }

    public function setViewsCount(int $views_count): static
    {
        $this->views_count = $views_count;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->title;
    }
}
