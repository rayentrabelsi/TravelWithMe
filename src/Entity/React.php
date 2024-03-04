<?php

namespace App\Entity;

use App\Repository\ReactRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReactRepository::class)]
class React
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?int $likes ;

    #[ORM\Column(length: 255)]
    private ?int $dislike = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userlike = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userdislike = null;

    public function __construct(?int $likes , ?int $dislike)
    {
        $this->likes = $likes;
        $this->dislike = $dislike;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): static
    {
        $this->likes = $likes;

        return $this;
    }

    public function getDislike(): ?int
    {
        return $this->dislike;
    }

    public function setDislike(int $dislike): static
    {
        $this->dislike = $dislike;

        return $this;
    }
    public function __toString(): string
    {
        // You can return any string that represents the object.
        // For example, if you have a property named 'name', you can return it.
        return $this->likes+$this->dislike;
    }
    public function incrementLikes(?String $authorC): void
    {
        $this->likes = $this->likes ? $this->likes + 1 : 1;
        $this->userlike =  $this->userlike ?  $this->userlike.";".$authorC : $authorC;
    }
    public function incrementDislike(?String $authorC): void
    {
        $this->dislike = $this->dislike ? $this->dislike + 1 : 1;
        $this->userdislike =  $this->userdislike ?  $this->userdislike.";".$authorC : $authorC;
    }

    public function getUserlike(): ?string
    {
        return $this->userlike;
    }

    public function setUserlike(?string $userlike): static
    {
        $this->userlike = $userlike;

        return $this;
    }

    public function getUserdislike(): ?string
    {
        return $this->userdislike;
    }

    public function setUserdislike(?string $userdislike): static
    {
        $this->userdislike = $userdislike;

        return $this;
    }
    public function decrementLikes(?String $authorC): void
    {
        $this->likes = $this->likes ? $this->likes -1 : 1;
        $this->userlike = str_replace($authorC, '', $this->userlike);
    }

    public function decrementDislike(?String $authorC): void
    {
        $this->dislike = $this->dislike ? $this->dislike -1 : 1;
        $this->userdislike = str_replace($authorC, '', $this->userdislike);
    }

}
