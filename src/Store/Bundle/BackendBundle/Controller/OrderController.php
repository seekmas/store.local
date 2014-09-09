<?php
namespace Store\Bundle\BackendBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Store\Bundle\BackendBundle\Form\Type\OrdersType;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends CoreController
{
    public function indexAction()
    {

        $user = $this->getUser();
        $store = $this->get('store.repo')->findOneBy(['userId'=>$user->getId()]);

        $pagination = $this->get('order.paginator')
            ->setCondition([])
            ->createPagination();
        return $this->render('StoreBackendBundle:Order:index/index.html.twig' ,
            [
                'orders' => $pagination
            ]
        );
    }

    public function updateAction(Request $request, $orderId)
    {

        $em = $this->getDoctrine()->getManager();

        $order = $this->get('order.repo')->findOneByOrderId($orderId);

        if( $order == NULL)
        {
            throw new EntityNotFoundException('订单不存在');
        }

        $em->persist($order);
        $form = $this->createNewForm($request , new OrdersType() , $order);

        if($form->isValid())
        {
            $this->addFlashMessage('success' , '更新订单快递跟踪代码成功');
            $em->flush();
            return $this->redirect($this->generateUrl('order_update' , ['orderId'=>$orderId]));
        }

        $total = $order->getShipment()? $order->getTotalCost() + $order->getShipment()->getShipmentPrice():$order->getTotalCost();

        return $this->render('StoreBackendBundle:Order:update/index.html.twig',
            [
                'order' => $order ,
                'total' => $total ,
                'form'  => $form->createView() ,
            ]
        );
    }

}