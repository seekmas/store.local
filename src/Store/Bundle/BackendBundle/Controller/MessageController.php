<?php

namespace Store\Bundle\BackendBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Store\Bundle\BackendBundle\Entity\MailTemplate;
use Store\Bundle\BackendBundle\Form\Type\MailTemplateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

        $store = $mail->getStore();

        return new Response( $this->get('mailer.send')->getTemplate($store,$mail->getMailTitle() , $mail->getMailContent()));
        //return $this->render('StoreBackendBundle:MailTemplate:preview/index.html.twig' , ['mail'=>$mail]);
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

    public function executeAction( $id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $dispatcher = $this->get('event_dispatcher');
        $store = $this->get('store.repo')->findOneBy(['userId'=>$user->getId()]);


        $users = $this->get('user.repo')->findAll();

        $mailTemplate = $this->get('mail.repo')
                             ->createQueryBuilder('m')
                             ->select('m')
                             ->AndWhere('m.id = '.$id)
                             ->AndWhere('m.storeId = '.$store->getId())
                             ->getQuery()
                             ->getResult();

        $subscribers = $this->get('subscriber.repo')->findAll();

        foreach( $mailTemplate as $template)
        {
            $list = [];
            foreach($users as $user)
            {
                $list[] = $user->getEmail();
            }

            foreach($subscribers as $subscriber)
            {
                $list[] = $subscriber->getEmail();
            }

            $list= array_unique($list);

            $mailer = $this->get('mailer.send');
            $mailer->setConfig( $template->getFromEmail() , $template->getFromName() );
            $mailer->send($list , $template->getMailTitle() , $template->getMailContent()  ,$store);

            $em->persist( $template);
            $template->setIsSent(true);
            $em->flush();
        }
        return new Response('发送任务完成');
    }
}