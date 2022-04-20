<?php

namespace App\Repository;

use App\Entity\Specialty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Specialty|null find($id, $lockMode = null, $lockVersion = null)
 * @method Specialty|null findOneBy(array $criteria, array $orderBy = null)
 * @method Specialty[]    findAll()
 * @method Specialty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialtyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Specialty::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Specialty $entity, bool $flush = true): void
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
    public function remove(Specialty $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getSpecialties()
    {
        $queryBuilder = $this->createQueryBuilder('s')
            ->orderBy('s.id')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    /* Fonctions de Filtrage */
    public function getSpecialtiesByTitle()
    {
        $queryBuilder = $this->createQueryBuilder('s')
            ->orderBy('s.title', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
