<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
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
     * return Task[]
     * 
     */

    public function leftJoin($value):array{

        $qb= $this->createQueryBuilder('t');// t stands for representive of task table 
        $qb->select('t')
            ->leftJoin('App\Entity\User','u',Join::WITH,'u = t.userid')
            ->where('t.userid =:value')
            ->setParameter('value',$value)
            ->orderBy('t.id','ASC');

        $SQL= $qb->getQuery();
        return $SQL->execute(); 
    }
    /**
     * return Task[]
     */
    public function findByID($value): array
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.userid = :value')
            ->setParameter('value', $value)
            ->orderBy('t.id', 'ASC');
        $query = $qb->getQuery();
        return $query->execute();
    }

    // /**
    //  * @return Task[] Returns an array of Task objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Task
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
