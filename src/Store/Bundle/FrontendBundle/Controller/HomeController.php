<?php

namespace Store\Bundle\FrontendBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    public function indexAction()
    {

        $store = $this->get('store.repo')->findAll();

        if( $store == NULL)
        {
            return $this->render('StoreFrontendBundle:Home:under_construction.html.twig');
        }

        $standardStore = $store[0];

        $query = $this->get('basket.repo')->createQueryBuilder('p')
                      ->select('p')
                      ->where('p.storeId = '.$standardStore->getId());

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('StoreFrontendBundle:Home:index.html.twig',
            [
                'store' => $standardStore ,
                'products' => $pagination ,
            ]
        );
    }

    public function productAction( Request $request , $id)
    {

        $product = $this->get('product.repo')->find( $id);

        if( $product == NULL)
        {
            throw new EntityNotFoundException();
        }

        return $this->render('StoreFrontendBundle:Home:product/product.html.twig' ,
               [
                   'product' => $product
               ]
        );

    }

    public function shipmentAction()
    {

    }
}
