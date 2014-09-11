<?php

namespace Store\Bundle\BackendBundle\Mailer;

class SmtpMailer
{
    private $mailer ;
    private $fromEmail;
    private $fromName;
    private $service_container;

    public function __construct($service_container)
    {
        $this->service_container = $service_container;
    }

    public function send( $emails , $title , $body , $store)
    {

        if( is_array( $emails ) )
        {

            $message = \Swift_Message::newInstance()
                ->setSubject( $title)
                ->setFrom( array( $this->fromEmail => $this->fromName ))
                ->setTo( $emails )
                ->setBody( $this->format($store , $title , $body )  , 'text/html')
            ;
        }else if( is_string( $emails ))
        {
            $emails = explode( "," , $emails );
            $message = \Swift_Message::newInstance()
                ->setSubject($title)
                ->setFrom( array( $this->fromEmail => $this->fromName ))
                ->setTo( $emails )
                ->setBody( $this->format($store , $title , $body )  , 'text/html')
            ;
        }

        $transport = \Swift_SmtpTransport::newInstance( $store->getSmtpAddress()  , $store->getSmtpPort() , 'ssl')
            ->setUsername( $store->getSmtpUser())
            ->setPassword( $store->getSmtpPassword() );

        $this->mailer = \Swift_Mailer::newInstance( $transport);

        $this->mailer->send( $message);

        return $this->format($store , $title , $body );
    }

    public function getTemplate( $store , $title , $body )
    {
        $logo = $this->get('liip_imagine.cache.manager')->getBrowserPath( $store->getLogo() , 'banner');

        $body = <<<EOF
        <div style="background-color:#d0d0d0;background-image:url();text-align:center;padding:40px;">


            <div class="mmsgLetter" style="width:780px;margin:0 auto;padding:10px;color:#333;background-color:#fff;border:0px solid #aaa;border-radius:5px;-webkit-box-shadow:3px 3px 10px #999;-moz-box-shadow:3px 3px 10px #999;box-shadow:3px 3px 10px #999;font-family:Verdana, sans-serif; ">
            <div class="mmsgLetterHeader" style="height: 40px;background:url(/topline.jpg) repeat-x 0 0;">
            </div>
                <div class="mmsgLetterContent" style="padding:40px;font-size:20px;line-height:1.5;background:url( $logo ) no-repeat top left;">

                </div>
                <div style="text-align:left;">
                    $body
                </div>
                <div class="mmsgLetterFooter" style="margin:16px;text-align:center;font-size:12px;color:#888;text-shadow:1px 0px 0px #eee;"></div>
            </div>
        </div>

EOF;
        return $body;
    }

    public function setConfig( $fromEmail , $fromName )
    {
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
    }

    public function format($store , $title , $body )
    {
        $logo = $this->get('liip_imagine.cache.manager')->getBrowserPath( $store->getLogo() , 'banner');

        $body = <<<EOF
        <div style="background-color:#d0d0d0;background-image:url();text-align:center;padding:40px;">
            <div class="mmsgLetter" style="width:780px;margin:0 auto;padding:10px;color:#333;background-color:#fff;border:0px solid #aaa;border-radius:5px;-webkit-box-shadow:3px 3px 10px #999;-moz-box-shadow:3px 3px 10px #999;box-shadow:3px 3px 10px #999;font-family:Verdana, sans-serif; ">
            <div class="mmsgLetterHeader" style="height: 40px;background:url(/topline.jpg) repeat-x 0 0;">
            </div>
                <div class="mmsgLetterContent" style="padding:40px;font-size:20px;line-height:1.5;background:url( $logo ) no-repeat top left;">

                </div>
                <div style="text-align:left;">
                    $body
                </div>
                <div class="mmsgLetterFooter" style="margin:16px;text-align:center;font-size:12px;color:#888;text-shadow:1px 0px 0px #eee;"></div>
            </div>
        </div>

EOF;
        return $body;
    }

    protected function get($service)
    {
        return $this->service_container->get($service);
    }

}
