<?php

namespace Store\Bundle\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TopController extends Controller
{
    public function indexAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();

        if( $user == 'anon.')
        {
            return $this->render('StoreFrontendBundle:Top:index/anonymous.html.twig');
        }

        $cart = $this->get('cart.repo')->findOneBy(['userId'=>$user->getId() , 'expiredAt' => NULL]);

        return $this->render('StoreFrontendBundle:Top:index/sign.html.twig' ,
            [
                'cart' => $cart ,
            ]
        );
    }

    public function bottomAction()
    {
        $store = $this->get('store.repo')->findAll();
        $store = $store[0];

        return $this->render('StoreFrontendBundle:Top:bottom/index.html.twig' , ['store' => $store] );
    }
}