<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */

    public function findByExampleField($min,$max)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.nbPages < :max')
            ->setParameter('max', $max)
            ->andWhere('l.nbPages > :min')
            ->setParameter('min', $min)
            ->orWhere('l.dateEdition > :date')
            ->setParameter('date', '2000-01-01')
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findAllSQL() : array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery("SELECT u FROM App\Entity\Livre u");
        return $query->getResult();
    }


    public function test($min = 0, $max=1)
    {
        $em= $this->getEntityManager();
        $date0 =date_create ("2000-10-10");
        $date = date_format($date0,"Y-m-d");
        $query = $em->createQuery("SELECT u FROM App\Entity\Livre u WHERE (u.nbPages > ". $min ."AND u.nbPages <". $max .") OR (u.dateEdition > '2000-01-01') ORDER BY u.titre DESC");
        $ouvrier = $query->getResult();
        return $ouvrier;
    }
    public function findByPrixMoreThan( $prix)
    {
       return $this->createQueryBuilder('l')
           ->andWhere('l.prix> :val')
           ->setParameter('val',$prix)
           ->getQuery()
           ->getResult();
    }
    public function advaned_filter_request(
        $title,
        $dateEditionMin,
        $dateEditionMax,
        $prixMin,
        $prixMax,
        $categorie_id,
        $editeur_id,
        $auteur_id
        )
    {
        $query = $this->createQueryBuilder('l');
        if($title)
            $query
                ->andWhere('l.titre LIKE :title' )
                ->setParameter('title','%'.$title.'%');
        if($prixMin)
         $query
            ->andWhere('l.prix>= :prixmin')
            ->setParameter('prixmin',$prixMin);
        if($prixMax)
            $query
                ->andWhere('l.prix<= :prixmax')
                ->setParameter('prixmax',$prixMax);
        if($dateEditionMin)
            $query
                ->andWhere('l.dateEdition >= :datemin')
                ->setParameter('datemin',$dateEditionMin);
        if($dateEditionMax)
            $query
                ->andWhere('l.dateEdition < :datemax')
                ->setParameter('datemax',$dateEditionMax);
        if($categorie_id>0)
            $query
                ->andWhere('l.categorie = :cat_id')
                ->setParameter('cat_id',$categorie_id);
        if($auteur_id>0)
            $query
                ->andWhere('l.auteur = :aut_id')
                ->setParameter('aut_id',$auteur_id);
        if($editeur_id>0)
            $query
                ->andWhere('l.auteur = :edit_id')
                ->setParameter('edit_id',$editeur_id);
            return $query
            ->getQuery()
            ->getResult();
    }
}
