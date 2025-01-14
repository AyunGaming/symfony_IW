<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evenement>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }
    
    /**
     * Cette méthode récupère tous les événements, triés par date.
     */
    public function findAllEventsOrderedByDate(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.date', 'ASC') // Tri par date croissante
            ->getQuery()
            ->getResult();
    }

    /**
     * Vous pouvez aussi filtrer les événements futurs avec une méthode comme celle-ci :
     */
    public function findFutureEvents(): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.date > :today') // Filtre pour les événements futurs
            ->setParameter('today', new \DateTime())
            ->orderBy('e.date', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
