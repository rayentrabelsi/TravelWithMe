<?php

namespace App\Entity;

use App\Repository\CommentRepository;
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
}
