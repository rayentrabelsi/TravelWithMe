<?php

namespace App\Repository;
// src\Repository\PostRepository.php

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findByTitle($title)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.title LIKE :title')
            ->setParameter('title', '%'.$title.'%')
            ->getQuery()
            ->getResult();
    }
    public function findByTitleAndAuthor($title, $author)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.title = :title')
            ->andWhere('p.author = :author')
            ->setParameter('title', $title)
            ->setParameter('author', $author)
            ->getQuery()
            ->getResult();
    }
}
