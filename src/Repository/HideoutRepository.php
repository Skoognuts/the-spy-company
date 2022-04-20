<?php

namespace App\Repository;

use App\Entity\Hideout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hideout|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hideout|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hideout[]    findAll()
 * @method Hideout[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HideoutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hideout::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Hideout $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Hideout $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getHideouts()
    {
        $queryBuilder = $this->createQueryBuilder('h')
            ->orderBy('h.id')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    /* Fonctions de Filtrage */
    public function getHideoutsByCode()
    {
        $queryBuilder = $this->createQueryBuilder('h')
            ->orderBy('h.code', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getHideoutsByAddress()
    {
        $queryBuilder = $this->createQueryBuilder('h')
            ->orderBy('h.address', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getHideoutsByCountry()
    {
        $queryBuilder = $this->createQueryBuilder('h')
            ->orderBy('h.country', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getHideoutsByType()
    {
        $queryBuilder = $this->createQueryBuilder('h')
            ->orderBy('h.type', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
