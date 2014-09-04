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

        $pagination = $this->get('productBasket.paginator')
                           ->setCondition( ['storeId' => $standardStore->getId()] )
                           ->createPagination();

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
