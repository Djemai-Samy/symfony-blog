<?php
namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends ServiceEntityRepository {

  public function __construct(ManagerRegistry $doctrine) {

    parent::__construct($doctrine, Post::class);
  }


  function save(Post $entity): Post {
    $this->getEntityManager()->persist($entity);

    $this->getEntityManager()->flush();
    return $entity;
  }

  public function remove(Post $entity) {
    $this->getEntityManager()->remove($entity);
    $this->getEntityManager()->flush();
    return true;
  }
}