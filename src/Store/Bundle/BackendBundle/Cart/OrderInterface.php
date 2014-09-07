<?php

namespace Store\Bundle\BackendBundle\Cart;

use Store\Bundle\BackendBundle\Entity\Orders;

interface OrderInterface
{
    public function createOrder($cartId);
    public function createPayment($orderId);
    public function updateOrderStatue($orderId , OrderStatus $status_code);
    public function setOrder(Orders $order);
    public function getOrder();
    public function getAllOrders();
}