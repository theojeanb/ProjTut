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
                    SELECT a.id,a.nom, a.degats, a.rarete, a.sprite, a.prix, i.id AS inventID
                    FROM App:Arme a
                    JOIN App:Inventaire i
                    WHERE i.joueur =  '.$UserId.' and IDENTITY(i.arme) IS NOT NULL and a.id = IDENTITY(i.arme)
                    and i.id not in (SELECT IDENTITY(e.arme) FROM App:Equipement e WHERE IDENTITY(e.arme) IS NOT NULL)');
        return $query->getResult();
    }

    public function findAllArmures($UserId)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                    SELECT a.id,a.nom, a.defense, a.rarete, a.sprite, a.prix, t.nom AS nomType, i.id AS inventID, i.id
                    FROM App:Inventaire i
                    JOIN App:Armure a
                    JOIN App:Type t
                    WHERE i.joueur =  '.$UserId.' and IDENTITY(i.armure) IS NOT NULL and IDENTITY(a.type) = t.id and a.id = IDENTITY(i.armure) 
                    and i.id not in (SELECT IDENTITY(w.plastron) FROM App:Equipement w WHERE IDENTITY(w.plastron) IS NOT NULL)
                    and i.id not in (SELECT IDENTITY(x.casque) FROM App:Equipement x WHERE IDENTITY(x.casque) IS NOT NULL)
                    and i.id not in (SELECT IDENTITY(y.bottes) FROM App:Equipement y WHERE IDENTITY(y.bottes) IS NOT NULL)
                    and i.id not in (SELECT IDENTITY(z.jambieres) FROM App:Equipement z WHERE IDENTITY(z.jambieres) IS NOT NULL)');
        return $query->getResult();
    }

    public function findAllPotions($UserId)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                    SELECT p.id,p.nom, p.effet, p.valeur, p.rarete, p.sprite, p.prix, i.id AS inventID
                    FROM App:Potion p
                    JOIN App:Inventaire i
                    WHERE i.joueur =  '.$UserId.' and IDENTITY(i.potion) IS NOT NULL and p.id = IDENTITY(i.potion)
                    and i.id not in (SELECT IDENTITY(e.potion) FROM App:Equipement e WHERE IDENTITY(e.potion) IS NOT NULL)');
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
