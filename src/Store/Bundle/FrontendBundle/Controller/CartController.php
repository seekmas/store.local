<?php

namespace Store\Bundle\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    public function indexAction( Request $request)
    {

        $store = $this->get('store.repo')->findAll();
        $store = $store[0];

        return $this->render('StoreFrontendBundle:Cart:index.html.twig' , [ 'store' => $store ]);
    }

    public function addAction( $id)
    {

    }
}