<?php

namespace Store\Bundle\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {


        $city = $this->get('city.repo')->findAll();

        return $this->render('StoreFrontendBundle:Home:index.html.twig',
            [
                'city' => $city ,
            ]
        );
    }

}
