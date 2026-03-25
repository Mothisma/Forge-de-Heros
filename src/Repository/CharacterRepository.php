<?php

namespace App\Repository;

use App\Entity\Character;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Character>
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    public function findByFilters(?int $classId, ?int $raceId, ?string $name): array
    {
        $qb = $this->createQueryBuilder('c');

        if ($classId) {
            $qb->andWhere('c.Class = :classId')
                ->setParameter('classId', $classId);
        }

        if ($raceId) {
            $qb->andWhere('c.Race = :raceId')
                ->setParameter('raceId', $raceId);
        }

        if ($name) {
            $qb->andWhere('c.name LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        }

        return $qb->getQuery()->getResult();
    }

}
