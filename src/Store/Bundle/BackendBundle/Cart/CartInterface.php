<?php

namespace Store\Bundle\BackendBundle\Cart;

use Store\Bundle\BackendBundle\Entity\CartItem;
use Store\Bundle\BackendBundle\Entity\Product;


interface CartInterface
{
    public function getCart();
    public function getItems();
    public function addProduct(Product $product , $params);
    public function removeItem();
}