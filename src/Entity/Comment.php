<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id_comment = null;

    #[ORM\Column(length: 255)]
    private ?string $authorC = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column]
    private ?int $replies_count = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(name: 'post_id', referencedColumnName: 'id_post')]
    private ?Post $post = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?React $reacts = null;

    #[ORM\Column]
    private ?int $signaler = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(name: 'parent_comment_id', referencedColumnName: 'id_comment')]
    private ?self $parentcomment = null;

    #[ORM\OneToMany(mappedBy: 'parentcomment', targetEntity: self::class)]
    private Collection $comments;

    public function __construct(?React $react,?int $signaler)
    {
        $this->reacts = $react;
        $this->signaler = $signaler;
        $this->comments = new ArrayCollection();

    }
    public function getIdComment(): ?int
    {
        return $this->id_comment;
    }

    public function setIdComment(int $id_comment): static
    {
        $this->id_comment = $id_comment;

        return $this;
    }

    public function getAuthorC(): ?string
    {
        return $this->authorC;
    }

    public function setAuthorC(string $authorC): static
    {
        $this->authorC = $authorC;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function getRepliesCount(): ?int
    {
        return $this->replies_count;
    }

    public function setRepliesCount(int $replies_count): static
    {
        $this->replies_count = $replies_count;

        return $this;
    }

    public function getPost(): ?Post

    {
        return $this->post;
    }

    public function setPost(?Post $post): static
    {
        $this->post = $post;

        return $this;
    }

    public function getReacts(): ?React
    {
        return $this->reacts;
    }

    public function setReacts(?React $reacts): static
    {
        $this->reacts = $reacts;

        return $this;
    }

    public function getSignaler(): ?int
    {
        return $this->signaler;
    }

    public function setSignaler(int $signaler): static
    {
        $this->signaler = $signaler;

        return $this;

    }

    // Méthode pour incrémenter le compteur de signalements
    public function incrementSignaler(): void
    {
        $this->signaler = $this->signaler ? $this->signaler + 1 : 1;
    }

    public function getParentcomment(): ?self
    {
        return $this->parentcomment;
    }

    public function setParentcomment(?self $parentcomment): static
    {
        $this->parentcomment = $parentcomment;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(self $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setParentcomment($this);
        }

        return $this;
    }

    public function removeComment(self $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getParentcomment() === $this) {
                $comment->setParentcomment(null);
            }
        }

        return $this;
    }




}

