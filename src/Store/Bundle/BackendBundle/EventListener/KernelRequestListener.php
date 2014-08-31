<?php

namespace Store\Bundle\BackendBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class KernelRequestListener
{

    protected $container;

    public function __construct($service_container)
    {
        $this->container = $service_container;
    }

    public function onKernelRequest( GetResponseEvent $event)
    {
        if( $this->container->get('security.context')->isGranted('STORE_AGENT') )
        {
            $response = new Response('Not allowed' , 403 );

            $event->setResponse( $response);
        }
    }
}