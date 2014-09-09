<?php

namespace Store\Bundle\BackendBundle\Mailer;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Service("smtp.sender")
 */
class SmtpMailer
{
    private $mailer;
    private $user;

    /**
     * @DI\InjectParams(
     *  {
     *      "service_container" = @DI\Inject("service_container")
     *  }
     * )
     */
    public function __construct($service_container)
    {
        $this->user = $service_container->get('security.context')->getToken()->getUser();
        $this->mailer = $service_container->get('swiftmailer.transport');
    }

    public function send($title,$content)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($title)
            ->setFrom('446146366@qq.com')
            ->setTo('446146366@qq.com')
            ->setBody($content);
        $this->mailer->send($message);

    }
}