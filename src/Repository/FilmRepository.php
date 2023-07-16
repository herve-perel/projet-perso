<?php

namespace App\Repository;

use App\Entity\Actor;
use App\Entity\Director;
use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Film>
 *
 * @method Film|null find($id, $lockMode = null, $lockVersion = null)
 * @method Film|null findOneBy(array $criteria, array $orderBy = null)
 * @method Film[]    findAll()
 * @method Film[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Film::class);
    }

    public function save(Film $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Film $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findFilm(?string $search): array
    {
        $queryBuilder = $this->createQueryBuilder('f')
            ->leftJoin('f.actors', 'a')
            ->leftJoin('f.director', 'd') // Jointure avec la table des acteurs
            ->where('f.title LIKE :search')
            ->orWhere('a.name LIKE :actor')
            ->orWhere('d.name LIKE :director')
            ->setParameter('search', '%' . $search . '%')
            ->setParameter('actor', '%' . $search . '%')
            ->setParameter('director', '%' . $search . '%')
            ->orderBy('f.title', 'ASC')
            ->getQuery();
    
        return $queryBuilder->getResult();
    }
}
