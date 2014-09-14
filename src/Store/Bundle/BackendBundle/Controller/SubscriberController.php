<?php

namespace Store\Bundle\BackendBundle\Controller;

use Store\Bundle\BackendBundle\Entity\Subscriber;
use Symfony\Component\HttpFoundation\Request;

class SubscriberController extends CoreController
{
    public function indexAction(Request $request)
    {
        $store = $this->getStore();
        $subscribers = $this->get('sucscriber.paginator')
            ->setCondition( ['storeId' => $store->getId()])
            ->setPerPage(200)
            ->createPagination();

        return $this->render('StoreBackendBundle:Subscriber:index/index.html.twig' ,
            [
                'subscribers' => $subscribers
            ]
        );
    }
}
