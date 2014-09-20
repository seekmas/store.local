<?php

namespace Store\Bundle\BackendBundle\Controller;

use Store\Bundle\BackendBundle\Entity\BankInfo;
use Store\Bundle\BackendBundle\Form\BankInfoType;
use Symfony\Component\HttpFoundation\Request;

class BankController extends CoreController
{
    public function indexAction(Request $request)
    {
        $bank = $this->get('bank.repo')->findAll();
        if(isset($bank[0]))
        {
            $bank = $bank[0];
        }
        else
        {
            $bank = new BankInfo();
        }

        $em = $this->getDoctrine()->getManager();


        $form = $this->createNewForm($request,new BankInfoType(),$bank);
        if($form->isValid())
        {
            $em->persist($bank);
            $em->flush();
            $this->addFlashMessage('success' , '银行汇款信息更新成功');
            return $this->redirect($this->generateUrl('bankinfo'));
        }

        return $this->render('StoreBackendBundle:Bank:index.html.twig' , ['form'=>$form->createView()]);
    }
}