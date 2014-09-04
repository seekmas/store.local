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

        return $this->render('StoreFrontendBundle:Top:index/sign.html.twig');

    }
}