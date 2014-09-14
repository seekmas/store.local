<?php

namespace Store\Bundle\FrontendBundle\Controller;

use Store\Bundle\BackendBundle\Controller\CoreController;
use Store\Bundle\BackendBundle\Entity\Subscriber;
use Store\Bundle\BackendBundle\Form\Type\SubscriberType;
use Symfony\Component\HttpFoundation\Request;

class SubscriberController extends CoreController
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $store = $this->get('store.repo')->findAll();

        if( $store == NULL)
        {
            return $this->render('StoreFrontendBundle:Home:under_construction.html.twig');
        }

        $store = $store[0];

        $subscriber = new Subscriber();
        $subscriber->setStore($store);
        $form = $this->createNewForm($request,new SubscriberType(),$subscriber);
        if( $form->isValid())
        {
            $data = $form->getData();
            $the_subscriber = $this->get('subscriber.repo')->findOneBy(['email' => $data->getEmail() , 'storeId'=>$store->getId()]);

            if( $the_subscriber)
            {
                $this->addFlashMessage('success' , '订阅成功');
                return $this->redirect($this->generateUrl('subscribe'));
            }

            $subscriber->setCreatedAt(new \Datetime());
            $em->persist($subscriber);
            $em->flush();
            $this->addFlashMessage('success' , '订阅成功');
            return $this->redirect($this->generateUrl('subscribe'));
        }

        return $this->render('StoreFrontendBundle:Subscriber:index/index.html.twig' ,
            [
                'form' => $form->createView() ,
                'store' => $store ,
            ]
        );

    }
}