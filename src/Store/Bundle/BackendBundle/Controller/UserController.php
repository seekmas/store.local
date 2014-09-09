<?php

namespace Store\Bundle\BackendBundle\Controller;

use Store\Bundle\BackendBundle\Controller\CoreController as Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction(Request $request)
    {

        $users = $this->get('user.paginator')->createPagination();

        return $this->render(
            'StoreBackendBundle:User:index/index.html.twig' ,
            [
                'users' => $users
            ]
        );
    }

    public function userAction(Request $request , $userId)
    {
        $user = $this->get('user.repo')->find($userId);

        $orders = $this->get('order.repo')->findBy(['userId' => $userId]);

        $carts = $this->get('cart.repo')->findBy(['userId' => $userId]);

        return $this->render('StoreBackendBundle:User:user/index.html.twig' ,
            [
                'user' => $user ,
                'orders' => $orders ,
                'carts' => $carts ,
            ]
        );
    }


}