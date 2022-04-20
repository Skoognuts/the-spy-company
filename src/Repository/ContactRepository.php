<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Contact $entity, bool $flush = true): void
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
    public function remove(Contact $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getContacts()
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->orderBy('c.id')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    /* Fonctions de Filtrage */
    public function getContactsByLastName()
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->orderBy('c.lastName', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getContactsByFirstName()
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->orderBy('c.firstName', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getContactsByBirthDate()
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->orderBy('c.dateOfBirth', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getContactsByCodeName()
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->orderBy('c.codeName', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function getContactsByNationality()
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->orderBy('c.nationality', 'asc')
        ;
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
