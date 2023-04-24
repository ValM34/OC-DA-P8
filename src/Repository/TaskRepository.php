<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 *
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findByIsDone(User $user, bool $isDone)
    {
        return $this->createQueryBuilder('t')
          ->select('t', 'u')
          ->leftJoin('t.user', 'u')
          ->andWhere('u = :user')
          ->andWhere('t.isDone = :isDone')
          ->setParameter('isDone', $isDone)
          ->setParameter('user', $user)
          ->getQuery()
          ->getResult()
        ;
    }
}
