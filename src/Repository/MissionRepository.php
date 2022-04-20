<?php

namespace App\Repository;

use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mission[]    findAll()
 * @method Mission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Mission $entity, bool $flush = true): void
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
    public function remove(Mission $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getMissions()
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->orderBy('m.id')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getMissionById(int $id)
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->where('m.id = :id')
            ->setParameter('id', $id)
        ;
        $query = $queryBuilder->getQuery();

        return $query->getOneOrNullResult();
    }

    /* Fonctions de Filtrage */
    public function getMissionsByTitle()
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->orderBy('m.title', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getMissionsByCountry()
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->orderBy('m.country', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getMissionsByStatus()
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->orderBy('m.status', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getMissionsByType()
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->orderBy('m.type', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
