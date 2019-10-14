<?php

namespace App\Repository;

use App\Entity\TicTacToeGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TicTacToeGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicTacToeGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicTacToeGame[]    findAll()
 * @method TicTacToeGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicTacToeGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicTacToeGame::class);
    }

    // /**
    //  * @return TicTacToeGame[] Returns an array of TicTacToeGame objects
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
    public function findOneBySomeField($value): ?TicTacToeGame
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
