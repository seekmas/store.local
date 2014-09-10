<?php

namespace Store\Bundle\BackendBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Store\Bundle\BackendBundle\Entity\MailTemplate;
use Store\Bundle\BackendBundle\Form\Type\MailTemplateType;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends CoreController
{
    //list all template
    public function indexAction(Request $request , $id = null)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $dispatcher = $this->get('event_dispatcher');

        $store = $this->get('store.repo')->findOneBy(['userId'=>$user->getId()]);

        if( $id == null)
        {
            $mailTemplate = new MailTemplate();
        }else
        {
            $mailTemplate = $this->get('mail.repo')->findOneBy(['id'=>$id,'storeId'=>$store->getId()]);
            if( $mailTemplate == NULL)
            {
                throw new EntityNotFoundException();
            }
        }

        $em->persist($mailTemplate);
        $form = $this->createNewForm($request,new MailTemplateType() , $mailTemplate);

        if( $form->isValid())
        {
            $mailTemplate->setStore($store);
            $mailTemplate->setCreatedAt(new \Datetime());
            $mailTemplate->setIsSent(false);
            $em->flush();

            $this->addFlashMessage('success' , '群发邮件任务添加成功');
            return $this->redirect($this->generateUrl('mail'));
        }

        $pagination = $this->get('mail.paginator')
            ->setCondition( ['storeId' => $store->getId()] )
            ->setOrderBy('id')
            ->createPagination();

        return $this->render('StoreBackendBundle:MailTemplate:index/index.html.twig' ,

            [
                'pagination' => $pagination ,
                'form' => $form->createView() ,
            ]
        );

    }

    public function previewAction($id)
    {
        $mail = $this->get('mail.repo')->find( $id);

        return $this->render('StoreBackendBundle:MailTemplate:preview/index.html.twig' , ['mail'=>$mail]);
    }

    public function removeAction(Request $request , $id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $dispatcher = $this->get('event_dispatcher');

        $store = $this->get('store.repo')->findOneBy(['userId'=>$user->getId()]);

        $mailTemplate = $this->get('mail.repo')->findOneBy(['id'=>$id,'storeId'=>$store->getId()]);
        if( $mailTemplate == NULL)
        {
            throw new EntityNotFoundException();
        }

        $em->persist($mailTemplate);
        $mailTemplate->setRemovedAt( new \Datetime());
        $em->flush();
        $this->addFlashMessage('success' , '邮件模板删除成功');
        return $this->redirect($this->generateUrl('mail'));
    }
}