<?php

namespace App\Repository;

use App\Entity\Target;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Target|null find($id, $lockMode = null, $lockVersion = null)
 * @method Target|null findOneBy(array $criteria, array $orderBy = null)
 * @method Target[]    findAll()
 * @method Target[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TargetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Target::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Target $entity, bool $flush = true): void
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
    public function remove(Target $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    
    public function getTargets()
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->orderBy('t.id')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    /* Fonctions de Filtrage */
    public function getTargetsByLastName()
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->orderBy('t.lastName', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getTargetsByFirstName()
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->orderBy('t.firstName', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getTargetsByBirthDate()
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->orderBy('t.dateOfBirth', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getTargetsByCodeName()
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->orderBy('t.codeName', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getTargetsByNationality()
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->orderBy('t.nationality', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
