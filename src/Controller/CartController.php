<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[IsGranted('ROLE_CUSTOMER')]
    #[Route('/cart', name: 'add_to_cart')]
    public function addToCart(Request $request) 
    {
        $session = $request->getSession();  
        $id = $request->get('productid'); //gửi 2 dữ liệu: dữ liệu id của product id và quantity
        $session->set('productid',$id); //set vào session
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $session->set('product', $product);
        $quantity = $request->get('quantity');
        $session->set('quantity', $quantity);
        $date = date('Y/m/d');  //get current date
        $session->set('date', $date);
        $datetime = date('Y/m/d H:i:s'); //get current date + time
        $session->set('date', $date);
        $session->set('datetime', $datetime);
        $product_price = $product->getPrice();
        $order_price = $product_price * $quantity;
        $session->set('price', $order_price);

        return $this->render('cart/index.html.twig');
    }

    
    #[Route('/order', name: 'make_order')]
    public function makeOrder(Request $request, ManagerRegistry $managerRegistry) 
    {
        //tạo session mới
        $session = new Session();
        //thay đổi quantity sau khi ord
        $product = $this->getDoctrine()->getRepository(Product::class)->find($session->get('productid'));
        $product_quantity = $product->getQuantity();
        $order_quantity = $session->get('quantity'); //tạo object Order để lưu thông tin đơn hàng
        $new_quantity = $product_quantity - $order_quantity;
        $product->setQuantity($new_quantity);
        $manager = $managerRegistry->getManager();//manager: lưu object vào database
        $manager->persist($product);
        $manager->flush();

        $this->addFlash('Info', 'Order successfully !');// gửi thông báo bằng view
  
        return $this->redirectToRoute('product_home');// redirect về trang home sau khi confirm order
    }
}
