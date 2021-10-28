<?php

namespace App\Repository;

use App\Entity\EmpruntLivres;
use App\Entity\Livre;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EmpruntLivres|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmpruntLivres|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmpruntLivres[]    findAll()
 * @method EmpruntLivres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmpruntLivresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmpruntLivres::class);
    }

    // /**
    //  * @return EmpruntLivres[] Returns an array of EmpruntLivres objects
    //  */

    public function findWeeklyUserEmprunts(User $user)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.User = :val')
            ->setParameter('val', $user)
            ->andWhere('e.date_de_reservation > :lastWeekDate')
            ->setParameter('lastWeekDate', (new \DateTime('now'))->modify('- 1week'))
            ->getQuery()
            ->getResult()
        ;
    }





    /*
    public function findOneBySomeField($value): ?EmpruntLivres
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
