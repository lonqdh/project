<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'add_to_cart')]
    public function addToCart(Request $request) 
    {
        $session = $request->getSession();
        $id = $request->get('productid');
        $session->set('productid',$id);
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
        $user = $this->getUser(); //get current user
        $session->set('user', $user);
        return $this->render('cart/index.html.twig');
    }

    #[Route('/order', name: 'make_order')]
    public function makeOrder(Request $request, ManagerRegistry $managerRegistry) 
    {
        //khởi tạo session
        $session = new Session();

        //giảm quantity của book sau khi order
        $product = $this->getDoctrine()->getRepository(Product::class)->find($session->get('productid'));
        $product_quantity = $product->getQuantity();
        $order_quantity = $session->get('quantity');
        $new_quantity = $product_quantity - $order_quantity;
        $product->setQuantity($new_quantity);

        //tạo object Order để lưu thông tin đơn hàng

        //set từng thuộc tính cho bảng Order 
        //VD: $order->setPrice()

        //dùng Manager để lưu object vào DB
        $manager = $managerRegistry->getManager();
        $manager->persist($product);
        $manager->flush();

        //gửi thông báo về view bằng addFlash
        $this->addFlash('Info', 'Order successfully !');
  
        //redirect về trang book store
        return $this->redirectToRoute('product_home');
    }
}
