<?php

namespace Store\Bundle\BackendBundle\Controller;

use Store\Bundle\BackendBundle\Entity\Store;
use Store\Bundle\BackendBundle\Form\Type\StoreType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    public function homeAction( Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.context')->getToken()->getUser();

        $store = $this->get('store.repo')->findOneBy(['userId' => $user->getId() ]);

        if( NULL === $store)
        {
            $store = new Store();
        }

        $tmp_image = $store->getLogo();
        $store->setLogo(NULL);


        $em->persist($store);

        $form = $this->createNewForm( $request , new StoreType() , $store );

        if( $form->isValid())
        {

            $data = $form->getData();
            $logo = $data->getLogo();

            if( $logo)
            {

                $this->get('file.save')->remove( $tmp_image);
                $logo = $this->get('file.save')->save( $logo , 'store' );
                $store->setLogo( $logo);
            }else
            {
                $store->setLogo( $tmp_image);
            }

            $store->setUser( $user );
            $store->setCreatedAt( new \Datetime());
            $em->flush();

            return $this->redirect(
                $this->generateUrl('store')
            );
        }

        $store->setLogo( $tmp_image);

        return $this->render( 'StoreBackendBundle:Home:index/index.html.twig' ,
            [
                'form' => $form->createView() ,
                'store' => $store ,
            ]
        );
    }

    protected function createNewForm(Request $request , AbstractType $type , $entity)
    {
        $form = $this->createForm( $type , $entity );
        $form->handleRequest( $request );
        return $form;
    }
}