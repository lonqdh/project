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


    public function sortBestSellingProducts()
    {
        return $this->createQueryBuilder('product')
        ->orderBy('product.quantity', 'ASC')
            ->setMaxResults(2)
            ->getQuery()
            ->getResult()
            ;
    }

    public function searchProduct($key)
    {
        return $this->createQueryBuilder('product')
        ->andWhere('product.name LIKE :key')
        ->setParameter('key', '%'. $key .'%')
        ->setMaxResults(5)
        ->getQuery()
        ->getResult()
        ;
    }

    

    /*
    public function findOneBySomeField($value): ?Material
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
