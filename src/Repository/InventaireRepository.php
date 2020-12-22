<?php

namespace App\Repository;

use App\Entity\Inventaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inventaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inventaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inventaire[]    findAll()
 * @method Inventaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inventaire::class);
    }

    public function findAllArmes($UserId)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                    SELECT i.arme, estEquipe
                    FROM App:Inventaire i
                    WHERE i.joueur =  '.$UserId.' and i.arme IS NOT NULL');
        return $query->getResult();
    }

    public function findAllArmures($UserId)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                    SELECT i.armure, estEquipe
                    FROM App:Inventaire i
                    WHERE i.joueur =  '.$UserId.' and i.armure IS NOT NULL');
        return $query->getResult();
    }

    public function findAllPotions($UserId)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                    SELECT i.potion, estEquipe
                    FROM App:Inventaire i
                    WHERE i.joueur =  '.$UserId.' and i.potion IS NOT NULL');
        return $query->getResult();
    }

    // /**
    //  * @return Inventaire[] Returns an array of Inventaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Inventaire
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
