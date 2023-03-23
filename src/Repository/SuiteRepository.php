<?php

namespace App\Repository;

use App\Entity\Suite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Suite>
 *
 * @method Suite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Suite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Suite[]    findAll()
 * @method Suite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Suite::class);
    }

    public function save(Suite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Suite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findAllSuitesByHotelId(int $hotelId): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.hotel = :hotelId')
            ->setParameter('hotelId', $hotelId)
            ->getQuery()
            ->getResult();
    }

    public function findAvailableSuites(string $city, \DateTimeInterface $checkInDate, \DateTimeInterface $checkOutDate, int $beds)
    {
        $qb = $this->createQueryBuilder('s');

        $qb->join('s.hotel', 'h')
            ->andWhere('h.city = :city')
            ->setParameter('city', $city)
            ->andWhere('s.beds >= :beds')
            ->setParameter('beds', $beds)
            ->andWhere('s NOT IN (
            SELECT b2 FROM App\Entity\Booking b2
            WHERE b2.checkInDate < :checkOutDate AND b2.checkOutDate > :checkInDate AND b2.suite = s
        )')
            ->setParameter('checkInDate', $checkInDate)
            ->setParameter('checkOutDate', $checkOutDate);

        return $qb->getQuery()->getResult();
    }
}
