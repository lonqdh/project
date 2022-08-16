<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Product $entity, bool $flush = true): void
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
    public function remove(Product $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function sortProductPriceDesc()
    {
        return $this->createQueryBuilder('product')
            ->orderBy('product.price', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function sortProductPriceAsc()
    {
        return $this->createQueryBuilder('product')
            ->orderBy('product.price', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function searchProduct($keyword) 
    {
        return $this->createQueryBuilder('product')
            ->andWhere('product.name LIKE :key')
            ->setParameter('key', '%' . $keyword . '%')
            ->orderBy('product.price', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function sortBestSellingProducts()
    {
        return $this->createQueryBuilder('product')
        ->orderBy('product.quantity', 'ASC')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult()
            ;
    }

    public function sortCategoryShorts()
    {
        return $this->createQueryBuilder('product')
        ->orderBy('product.category.name', 'ASC')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult()
            ;
    }





}
