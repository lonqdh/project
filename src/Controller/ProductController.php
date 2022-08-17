<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/product')]
class ProductController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/index', name: 'product_index')]
    public function productIndex(): Response
    {

        
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('product/index.html.twig',
        [
            'products' => $products
        ]);
    }

    #[Route('/home', name :'product_home')]
    public function productList()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('product/home.html.twig',
        [
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
    #[IsGranted('ROLE_ADMIN')]
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

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/edit/{id}',name: 'product_edit')]
    public function productEdit ($id,ManagerRegistry $managerRegistry,Request $request)
    {
        $product = $managerRegistry->getRepository(Product::class)->find($id);
        if($product == null){
            $this->addFlash('Warning','Product does not exist !');
            return $this->redirectToRoute('product_index');
        }
        else{
            $productForm = $this->createForm(ProductType::class,$product);
            $productForm->handleRequest($request);
            if($productForm->isSubmitted() && $productForm->isValid())
            {
                $manager = $managerRegistry->getManager();
                $manager->persist($product);
                $manager->flush();
                $this->addFlash('Info', 'Edit product successfully !');
                return $this->redirectToRoute('product_index');
            }
        }

        return $this->renderForm('product/edit.html.twig',
        [
            'productForm' => $productForm
        ]);
    }
    
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/add',name:'product_add')]
    public function productAdd(Request $request)
    {
        $product = new Product;
        $productForm = $this->createForm(ProductType::class,$product);
        $productForm->handleRequest($request);
        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash('Info','Add product successfully !');
            return $this->redirectToRoute('product_index');
        }
        return $this->renderForm('product/add.html.twig',
        [
            'productForm' => $productForm
        ]);
    }

    #[IsGranted('ROLE_CUSTOMER')]
    #[Route('/price/asc', name: 'sort_price_ascending')]
    public function sortPriceAscending (ProductRepository $productRepository) {
      $products = $productRepository->sortProductPriceAsc();
      return $this->render('product/home.html.twig', 
      [
          'products' => $products
      ]);
    }
  
    #[IsGranted('ROLE_CUSTOMER')]
    #[Route('/price/desc', name: 'sort_price_descending')]
    public function sortPriceDescending (ProductRepository $productRepository) {
      $products = $productRepository->sortProductPriceDesc();
      return $this->render('product/home.html.twig', 
      [
          'products' => $products
      ]);
    }

    #[IsGranted('ROLE_CUSTOMER')]
    #[Route('/search', name: 'search_product')]
    public function searchProduct(ProductRepository $productRepository, Request $request) {
        $products = $productRepository->searchProduct($request->get('keyword'));
        // if ($books == null) {
        //   $this->addFlash("Warning", "No book found !");
        // }
        $session = $request->getSession();
        $session->set('search', true);
        return $this->render('product/home.html.twig', 
        [
            'products' => $products,
        ]);
    }

    #[IsGranted('ROLE_CUSTOMER')]
    #[Route('/bestselling/asc', name: 'sort_bestselling_ascending')]
    public function sortBestSellingProducts(ProductRepository $productRepository, Request $request) {
        $products = $productRepository->sortBestSellingProducts();
        return $this->render('product/home.html.twig', 
        [
            'products' => $products,
        ]);
    }

    


}
