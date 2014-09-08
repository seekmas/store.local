<?php

namespace Store\Bundle\BackendBundle;

final class PaymentEvents
{
    const VARIFY_FAIL = 'alipay.varify_fail';
    const VARIFY_SUCCESS = 'alipay.varify_success';
    const TRADE_FINISHED = 'alipay.trade_finished';
    const TRADE_SUCCESS = 'alipay.trade_fail';
}