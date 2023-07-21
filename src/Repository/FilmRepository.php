<?php

namespace App\Repository;

use App\Entity\Actor;
use App\Entity\Category;
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

    public function findFilm(?string $search, ?Category $category): array
    {
        $queryBuilder = $this->createQueryBuilder('f');
            if ($search) {
                $queryBuilder->where('f.title LIKE :title');
                $queryBuilder->setParameter('title', '%' . $search . '%');
            }

            if ($category) {
                $queryBuilder->where('f.category = :category');
                $queryBuilder->setParameter('category', $category);
            }

            $queryBuilder->orderBy('f.title', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    // public function paginationQuery()
    // {
    //     return $this->createQueryBuilder('f')
    //         ->orderBy('f.title', 'ASC')
    //         ->getQuery();
    // }
}
