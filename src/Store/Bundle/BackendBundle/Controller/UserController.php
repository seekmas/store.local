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

}