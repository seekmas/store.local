<?php

namespace Store\Bundle\FrontendBundle\Controller;

use Store\Bundle\BackendBundle\Entity\Address;
use Store\Bundle\BackendBundle\Form\Type\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    public function indexAction( Request $request)
    {
        $store = $this->get('store.repo')->findAll();
        $store = $store[0];

        return $this->render('StoreFrontendBundle:Cart:index.html.twig' , [ 'store' => $store ]);
    }

    public function dashboardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $store = $this->get('store.repo')->findAll();
        $store = $store[0];

        $cartManager = $this->get('store.cart');
        $cart = $cartManager->getCart();

        $address = new Address();
        $em->persist($address);
        $address->setUser( $user);

        $form = $this->createNewForm($request,new AddressType(),$address);
        if( $form->isValid())
        {
            $address->setIsDefault(false);
            $address->setCreatedAt( new \Datetime());
            $em->flush();

            $request->getSession()->getFlashBag()->add('success','新地址添加成功');
            return $this->redirect($this->generateUrl('checkout_dashboard'));
        }

        $defaultAddress = $this->get('address.repo')->findOneBy(['userId'=>$user->getId(),'isDefault' => 1]);

        $totalCost = 0;
        foreach($cart->getCartItem() as $item)
        {
            if( $item->getRemovedAt() == NULL)
                $totalCost += $item->getTotalPrice();
        }

        return $this->render('StoreFrontendBundle:Cart:dashboard/index.html.twig' ,
            [
                'store' => $store ,
                'cart'  => $cart ,
                'form'  => $form->createView() ,
                'user'  => $user ,
                'defaultAddress' => $defaultAddress ,
                'totalCost' => $totalCost
            ]
        );
    }

    public function addCartAction( $productId)
    {
        $product = $this->get('product.repo')->find($productId);

        $cartManager = $this->get('store.cart');
        $cartManager->addProduct($product);

        return $this->redirect($this->generateUrl('add_to_cart_success'));
    }

    public function addCartAndPayAction( $productId)
    {
        $product = $this->get('product.repo')->find($productId);

        $cartManager = $this->get('store.cart');
        $cartManager->addProduct($product);

        return $this->redirect($this->generateUrl('checkout_dashboard'));
    }
    public function setDefaultAddressAction(Request $request , $id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.context')->getToken()->getUser();

        $addresses = $user->getAddress();

        $defaultAddress = $this->get('address.repo')->findOneBy(['id' => $id , 'userId' => $user->getId()]);

        if( $defaultAddress == NULL)
        {
            $request->getSession()->getFlashBag()->add('danger' , '没有找到这个地址');
            return $this->redirect($this->generateUrl('checkout_dashboard'));
        }

        foreach($addresses as $address)
        {
            $em->persist( $address);
            $address->setIsDefault(false);
            $em->flush();
        }

        $defaultAddress->setIsDefault(true);
        $em->persist($defaultAddress);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success' , '当前寄送地址修改成功');

        return $this->redirect($this->generateUrl('checkout_dashboard'));

    }

    public function removeItemAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $item = $this->get('cart_item.repo')->find( $id);
        $cart = $item->getCart();

        if( $user->getId() == $cart->getUser()->getId())
        {
            $em->persist($item);
            $item->setRemovedAt(new \Datetime());
            $em->flush();
            $request->getSession()->getFlashBag()->add('success' , '移除成功');
        }else
        {
            $request->getSession()->getFlashBag()->add('danger' , '移除失败');
        }

        return $this->redirect($this->generateUrl('checkout_dashboard'));
    }

    public function changeNumberAction($itemId , $number)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $item = $this->get('cart_item.repo')->find($itemId);
        $cart = $item->getCart();
        if( $user->getId() == $cart->getUserId() )
        {
            $item->setSum($number);

            $single_price = $item->getProductBasket()->getProduct()->getproductPrice();
            $total_price = $single_price * $number;

            $item->setSinglePrice($single_price);
            $item->setTotalPrice($total_price);

            $em->persist($item);
            $em->flush();
        }

        return new Response();
    }

    protected function createNewForm(Request $request,AbstractType $type , $entity)
    {
        $form = $this->createForm($type , $entity);
        $form->handleRequest( $request);
        return $form;
    }
}