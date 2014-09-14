<?php

namespace Store\Bundle\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutController extends Controller
{
    public function indexAction()
    {
        $store = $this->get('store.repo')->findAll();

        if( $store == NULL)
        {
            return $this->render('StoreFrontendBundle:Home:under_construction.html.twig');
        }

        $store = $store[0];

        $pagination = $this->get('posts.paginator')
            ->setCondition( ['storeId' => $store->getId()  , 'enabled' => true] )
            ->setPerPage(1)
            ->createPagination();

        return $this->render('StoreFrontendBundle:About:index/index.html.twig' ,
            [
                'store' => $store ,
                'posts' => $pagination
            ]
        );
    }

}