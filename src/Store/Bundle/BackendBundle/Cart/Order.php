<?php

namespace Store\Bundle\BackendBundle\Cart;

use Store\Bundle\BackendBundle\Entity\Cart;
use Store\Bundle\BackendBundle\Entity\Orders;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Service;
use Store\Bundle\BackendBundle\Exception\AddressNotFoundException;


/**
 * @Service("order.manager")
 */
class Order implements OrderInterface
{
    private $_em;
    private $_security;
    private $_service_container;
    private $_format;

    /**
     * @DI\InjectParams(
     *  {
     *      "em"         = @DI\Inject("doctrine.orm.entity_manager"),
     *      "security"   = @DI\Inject("security.context"),
     *      "service_container" = @DI\Inject("service_container")
     *  }
     * )
     */
    public function __construct($em , $security , $service_container)
    {
        $this->_em = $em;
        $this->_security = $security;
        $this->_service_container = $service_container;
        $this->_format = 'json';
    }

    public function createOrder($cart)
    {
        $order = $this->get('order.repo')->findOneBy(
            [
                'cartId' => $cart->getId() ,
                'isLocked' => false ,
            ]
        );

        if( $order)
        {
            return $order;
        }

        $em = $this->_em;
        $user = $this->_security->getToken()->getUser();
        $serializer = $this->get('jms_serializer');
        $address = $this->get('address.repo')->findOneBy(['userId'=>$user->getId(),'isDefault'=>true]);

        if( $address == NULL)
        {
            throw new AddressNotFoundException();
        }

        $cartData = $this->_getCostAndDescription($cart);

        $order = new Orders();

        $order->setDescription($cartData['description']);
        $order->setTotalCost($cartData['cost']);
        $order->setCart($cart);
        $order->setUser($user);
        $order->setAddress($address);
        $order->setAlipayParams( $serializer->serialize([] , $this->getFormat()));
        $order->setIsLocked(false);
        $order->setPaymentStatus(OrderStatus::OrderCreated);
        $order->setCreatedAt(new \Datetime());
        $order->setIsLocked(false);

        $order->setPaymentStatus(OrderStatus::OrderCreated);
        $em->persist($order);
        $em->flush();
    }

    public function createPayment($orderId)
    {
        // TODO: Implement createPayment() method.
    }

    public function updateOrderStatue($orderId, OrderStatus $status_code)
    {
        // TODO: Implement updateOrderStatue() method.
    }

    public function setOrder(Orders $order)
    {
        // TODO: Implement setOrder() method.
    }

    public function getOrder()
    {
        // TODO: Implement getOrder() method.
    }

    public function getAllOrders()
    {
        // TODO: Implement getAllOrders() method.
    }

    /**
     * @param string $format
     * @return Order
     */
    public function setFormat($format)
    {
        $this->_format = $format;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->_format;
    }

    protected function _getCostAndDescription(Cart $cart)
    {
        $cost = 0;
        $description = '';
        foreach( $cart->getCartItem() as $item);
        {
            if( $item->getRemovedAt() == NULL)
            {
                $cost += $item->getTotalPrice();
                $description .= $item->getProductBasket()->getProduct()->getProductName().' x '.$item->getSum().'<br/>';
            }
        }
        return ['cost'=>$cost , 'description'=>$description];
    }

    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }

    public function get($service)
    {
        if( $this->_service_container->has($service))
            return $this->_service_container->get($service);
        else
            return ;
    }
}