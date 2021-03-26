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
                    SELECT a.id,a.nom, a.degats, a.rarete, a.sprite, a.prix
                    FROM App:Arme a
                    JOIN App:Inventaire i
                    WHERE i.joueur =  '.$UserId.' and IDENTITY(i.arme) IS NOT NULL and a.id = IDENTITY(i.arme)');
        return $query->getResult();
    }

    public function findAllArmures($UserId)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                    SELECT a.id,a.nom, a.defense, a.rarete, a.sprite, a.prix, t.nom AS nomType
                    FROM App:Armure a
                    JOIN App:Inventaire i
                    JOIN App:Type t
                    WHERE i.joueur =  '.$UserId.' and IDENTITY(i.armure) IS NOT NULL and IDENTITY(a.type) = t.id and a.id = IDENTITY(i.armure)');
        return $query->getResult();
    }

    public function findAllPotions($UserId)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                    SELECT p.id,p.nom, p.effet, p.valeur, p.rarete, p.sprite, p.prix
                    FROM App:Potion p
                    JOIN App:Inventaire i
                    WHERE i.joueur =  '.$UserId.' and IDENTITY(i.potion) IS NOT NULL and p.id = IDENTITY(i.potion)');
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
