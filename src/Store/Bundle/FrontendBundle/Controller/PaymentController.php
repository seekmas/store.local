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

        $cart = $this->get('cart.repo')->findOneBy( ['id'=>$cartId,'store'=>$store->getId()]);



    }
}