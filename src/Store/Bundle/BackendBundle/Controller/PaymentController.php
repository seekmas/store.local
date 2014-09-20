<?php

namespace Store\Bundle\BackendBundle\Controller;

use Store\Bundle\BackendBundle\Entity\Alipay;
use Store\Bundle\BackendBundle\Entity\Remittance;
use Store\Bundle\BackendBundle\Form\RemittanceType;
use Store\Bundle\BackendBundle\Form\Type\AlipayType;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends CoreController
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $store = $this->get('store.repo')->findOneBy(['userId'=>$user->getId()]);

        $alipay = new Alipay();
        $form = $this->createNewForm($request,new AlipayType(),$alipay);

        $alipays = $this->get('alipay.repo')->findBy(['storeId'=>$store->getId()]);

        if( $form->isValid())
        {
            $data = $form->getData();
            if( $data->getIsDefault())
            {
                foreach($alipays as $ali)
                {
                    if( $ali->getIsDefault())
                    {
                        $ali->setIsDefault(false);
                        $em->persist($ali);
                        $em->flush();
                    }
                }
            }

            $alipay->setStore($store);
            $em->persist($alipay);
            $em->flush();
            $this->addFlashMessage('success' , '支付宝添加成功');
            return $this->redirect($this->generateUrl('payment_manage'));
        }



        return $this->render('StoreBackendBundle:Payment:index.html.twig' ,
            [
                'form' => $form->createView() ,
                'alipays' => $alipays ,
            ]
        );
    }

    public function removeAction(Request $request , $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $store = $this->get('store.repo')->findOneBy(['userId'=>$user->getId()]);
        $alipay = $this->get('alipay.repo')->findOneBy(['id'=>$id,'storeId'=>$store->getId()]);

        if( $alipay)
        {
            $em->remove($alipay);
            $em->flush();
            $this->addFlashMessage('success' , '删除成功');

            return $this->redirect($this->generateUrl('payment_manage'));
        }
    }

    public function setDefaultAction(Request $request , $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $store = $this->get('store.repo')->findOneBy(['userId'=>$user->getId()]);
        $alipays = $this->get('alipay.repo')->findBy(['storeId'=>$store->getId()]);

        $alipay = $this->get('alipay.repo')->findOneBy(['id'=>$id,'storeId'=>$store->getId()]);

        if( $alipay)
        {
            foreach($alipays as $ali)
            {
                if( $ali->getIsDefault())
                {
                    $ali->setIsDefault(false);
                    $em->persist($ali);
                    $em->flush();
                }
            }

            $alipay->setIsDefault(true);
            $em->persist($alipay);
            $em->flush();
            $this->addFlashMessage('success' , '设置成功');

            return $this->redirect($this->generateUrl('payment_manage'));
        }
    }

}