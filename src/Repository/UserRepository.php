<?php
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\User;

class UserRepository extends ServiceEntityRepository {

  public function __construct(ManagerRegistry $doctrine) {

    parent::__construct($doctrine, User::class);
  }


  function save(User $entity): User {
    $this->getEntityManager()->persist($entity);

    $this->getEntityManager()->flush();
    return $entity;
  }

  public function remove(User $entity) {
    $this->getEntityManager()->remove($entity);
    $this->getEntityManager()->flush();
    return true;
  }
}