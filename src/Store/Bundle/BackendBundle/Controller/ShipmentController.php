<?php

namespace Store\Bundle\BackendBundle\Controller;

use Store\Bundle\BackendBundle\Entity\Shipment;
use Store\Bundle\BackendBundle\Form\Type\ShipmentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;

class ShipmentController extends Controller
{
    public function indexAction(Request $request , $id = 0)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.context')->getToken()->getUser();

        $store = $this->get('store.repo')->findOneBy(['userId'=>$user->getId()]);

        if( $id == 0)
        {
            $shipment = new Shipment();
            $shipment->setStore($store);

        }else
        {
            $shipment = $this->get('shipment.repo')->findOneBy(
                [
                    'storeId' => $store->getId() ,
                    'id'      => $id
                ]
            );
        }
        $em->persist($shipment);

        $form = $this->createNewForm($request,new ShipmentType(),$shipment);

        if( $form->isValid())
        {
            $shipment->setCreatedAt( new \Datetime());

            $em->flush();
            $request->getSession()->getFlashBag()->add('success' , '快递方式添加/更新成功');
            return $this->redirect($this->generateUrl('shipment'));
        }

        $shipments = $this->get('shipment.repo')->findBy(['storeId' => $store->getId()]);

        return $this->render('StoreBackendBundle:Shipment:index/index.html.twig' ,
            [
                'shipments' => $shipments ,
                'form' => $form->createView() ,
            ]
        );
    }

    public function removeShipmentAction(Request $request , $id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.context')->getToken()->getUser();

        $store = $this->get('store.repo')->findOneBy(['userId' => $user->getId()]);

        $shipment = $this->get('shipment.repo')->findOneBy(['storeId'=>$store->getId(),'id'=>$id]);

        if( $shipment == NULL )
        {
            $request->getSession()->getFlashBag()->add('danger' , '没有找到快递方式');
            return $this->redirect($this->generateUrl('shipment'));
        }

        $shipment->setRemovedAt( new \Datetime());
        $em->flush();
        $request->getSession()->getFlashBag()->add('success' , '快递方式删除成功');

        return $this->redirect($this->generateUrl('shipment'));
    }

    protected function createNewForm(Request $request , AbstractType $type , $entity)
    {
        $form = $this->createForm($type , $entity);

        $form->handleRequest( $request);

        return $form;
    }
}