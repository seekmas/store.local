<?php

namespace Store\Bundle\BackendBundle\Cart;

final class OrderStatus
{
    //订单创建失败
    const OrderCreateFail = 100;

    //订单创建完成
    const OrderCreated = 101;

    //将要支付
    const OrderPrePayment = 102;

    //开始支付
    const OrderPayment = 103;

    //支付失败
    const OrderPaymentFail = 104;

    //支付成功
    const OrderPaymentSuccess = 105;

    //发票创建
    const OrderInvoiceCreated = 106;
}