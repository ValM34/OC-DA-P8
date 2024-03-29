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

    /**
     * @return array<string>
     */
    public function findByIsDone(User $user, bool $isDone): array
    {
        return $this->createQueryBuilder('t')
            ->select('t', 'u')
            ->leftJoin('t.user', 'u')
            ->andWhere('u = :user')
            ->andWhere('t.isDone = :isDone')
            ->setParameter('isDone', $isDone)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<string>
     */
    public function findByIsDoneAdmin(User $user, bool $isDone): array
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->select('t', 'u')
            ->leftJoin('t.user', 'u')
            ->andWhere('t.isDone = :isDone')
            ->setParameter('isDone', $isDone)
            ->andWhere('u IS NULL')
            ->orWhere('u = :user')
            ->andWhere('t.isDone = :isDone')
            ->setParameter('isDone', $isDone)
            ->setParameter('user', $user)
        ;
        $taskList = $queryBuilder->getQuery()->getResult();
        foreach ($taskList as $task) {
            if ($task->getUser() === null) {
                $task->setTitle('[Anonyme] - ' . $task->getTitle());
            }
        }

        return $taskList;
    }
}
