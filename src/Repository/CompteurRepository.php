<?php

namespace App\Repository;

use App\Entity\Compteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Compteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Compteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Compteur[]    findAll()
 * @method Compteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Compteur::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.something = :value')->setParameter('value', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
