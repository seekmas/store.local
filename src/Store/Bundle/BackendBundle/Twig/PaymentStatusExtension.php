<?php

namespace Store\Bundle\BackendBundle\Twig;

//use Twig_Extension;

class PaymentStatusExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('display_status', array($this, 'display_status')),
        ];
    }

    public function display_status( $code)
    {
        $status_list =
            [
                100 => '<span class="label label-info">订单创建失败</span>' ,
                101 => '<span class="label label-primary">订单创建完成</span>' ,
                102 => '<span class="label label-info">将要支付</span>' ,
                103 => '<span class="label label-info">开始支付</span>' ,
                104 => '<span class="label label-danger">支付失败</span>' ,
                105 => '<span class="label label-success">支付成功</span>' ,
                106 => '<span class="label label-success">发票创建</span>' ,
            ];

        return $status_list[$code];
    }


    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'status_helper';
    }

}