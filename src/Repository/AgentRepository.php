<?php

namespace App\Repository;

use App\Entity\Agent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Agent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agent[]    findAll()
 * @method Agent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agent::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Agent $entity, bool $flush = true): void
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
    public function remove(Agent $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getAgents()
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->orderBy('a.id')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    /* Fonctions de Filtrage */
    public function getAgentsByIdCode(int $idCode)
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->where('a.identificationCode = :idCode')
            ->setParameter('idCode', $idCode)
            ->orderBy('a.identificationCode')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getAgentsByNationality(string $nationality)
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->where('a.nationality = :nationality')
            ->setParameter('nationality', $nationality)
            ->orderBy('a.id')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getAgentsBySpecialty(int $specialtyId)
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->where(':specialtyId MEMBER OF a.specialties')
            ->setParameter('specialtyId', $specialtyId)
            ->orderBy('a.id')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
