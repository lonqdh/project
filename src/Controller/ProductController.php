<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/index', name: 'product_index')]
    public function productIndex(): Response
    {
        //$books = $bookRepository->sortBookByIdDesc(); luc sau nho lam
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('/index.html.twig',
        [
            'products' => $products
        ]);
    }

    #[Route('/list', name :'product_list')]
    public function productList()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('product/list.html.twig',[
            'products' => $products
        ]);
    }

    #[Route('/detail/{id}', name : 'product_detail')]
    public function productDetail($id, ProductRepository $productRepository){
        $product = $productRepository->find($id);
        if ($product != null)
        {
            return $this->render('product/detail.html.twig',[
                'product' => $product
            ]);
        }
    }

    #[Route('/delete/{id}', name: 'product_delete')]
    public function productDelete ($id, ManagerRegistry $managerRegistry) {
      $product = $managerRegistry->getRepository(Product::class)->find($id);
      if ($product == null) {
          $this->addFlash('Warning', 'Product does not exist !');
      } 
      //check xem còn product trong product$product hay không trước khi xóa
    //   else if (count($product->getProduct()) > 0) {
    //     $this->addFlash('Warning', 'Can not delete this product !');
    //   }  nho uncomment sau khi tao product !!!
      else {
          $manager = $managerRegistry->getManager();
          $manager->remove($product);
          $manager->flush();
          $this->addFlash('Info', 'Delete product successfully !');
      }
      return $this->redirectToRoute('product_index');
    }





}
