<?php

namespace Store\Bundle\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends Controller
{
    public function indexAction(Request $request , $cartId)
    {
        $store = $this->get('store.repo')->findAll();
        $store = $store[0];
        $user = $this->getUser();
        $cart = $this->get('cart.repo')->findOneBy( ['id'=>$cartId,'userId'=>$user->getId()]);

        if( $cart == NULL)
        {
            return $this->redirect($this->generateUrl('checkout_dashboard'));
        }

        if( $cart->getExpiredAt() != NULL)
        {
            echo '购物车已经过期';
        }

        $address = $this->get('address.repo')->findOneBy(['userId'=>$user->getId(),'isDefault'=>true]);

        $shipments = $this->get('shipment.repo')->findAll();

        $order = $this->get('order.manager')->createOrder($cart);

        if( $address->getId() != $order->getAddress()->getId())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $order->setAddress( $address);
            $em->flush();
        }

        return $this->render('StoreFrontendBundle:Payment:index.html.twig' ,
            [
                'store' => $store ,
                'shipments' => $shipments ,
                'order' => $order ,
            ]
        );
    }

    public function selectShipmentAction(Request $request , $cartId , $shipmentId)
    {
        $shipment = $this->get('shipment.repo')->find($shipmentId);

        if( $shipment == NULL)
        {
            return $this->redirect($this->generateUrl('cart_to_payment' , ['cartId'=>$cartId]));
        }

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $cart = $this->get('cart.repo')->findOneBy( ['id'=>$cartId,'userId'=>$user->getId()]);
        $order = $this->get('order.manager')->createOrder($cart);
        $em->persist($order);
        $order->setShipment($shipment);
        $em->flush();

        return $this->redirect($this->generateUrl('cart_to_payment' , ['cartId'=>$cartId]));
    }

}