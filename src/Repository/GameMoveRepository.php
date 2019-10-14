<?php

namespace App\Repository;

use App\Entity\GameMove;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GameMove|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameMove|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameMove[]    findAll()
 * @method GameMove[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameMoveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameMove::class);
    }

    public function findByGame($game): ?array
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.game = :game')
            ->setParameter('game', $game)
            ->orderBy('g.turn', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

}
