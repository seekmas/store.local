<?php

namespace Store\Bundle\BackendBundle\Controller;

use Store\Bundle\BackendBundle\Entity\SocietyNetwork;
use Store\Bundle\BackendBundle\Form\Type\SocietyNetworkType;
use Symfony\Component\HttpFoundation\Request;

class SocietyController extends CoreController
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $store = $this->getStore();

        $society = new SocietyNetwork();
        $em->persist($society);
        $form = $this->createNewForm($request , new SocietyNetworkType() , $society);
        if($form->isValid())
        {
            $data = $form->getData();
            $icon = $data->getIcon();

            $icon = $this->get('file.save')->save($icon , 'societyNetwork');
            $society->setIcon($icon);
            $society->setStore($store);
            $em->flush();

            return $this->redirect($this->generateUrl('society'));
        }

        $societies = $this->get('society.repo')->findBy(['storeId'=>$store->getId()]);

        return $this->render('StoreBackendBundle:Society:index/index.html.twig' ,
            [
                'societies' => $societies ,
                'form' => $form->createView() ,
            ]
        );
    }

    public function removeAction($id)
    {
        $store = $this->getStore();
        $society = $this->get('society.repo')->findOneBy(['storeId'=>$store->getId(),'id'=>$id]);

        $this->get('file.save')->remove($society->getIcon());

        $em = $this->getDoctrine()->getManager();
        $em->remove($society);
        $em->flush();
        return $this->redirect($this->generateUrl('society'));
    }

}