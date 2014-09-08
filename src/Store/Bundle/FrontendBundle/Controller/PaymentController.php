<?php

namespace Store\Bundle\FrontendBundle\Controller;

use Store\Bundle\BackendBundle\Cart\OrderStatus;
use Store\Bundle\BackendBundle\Event\CommonEvent;
use Store\Bundle\BackendBundle\PaymentEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends Controller
{
    public function indexAction(Request $request , $cartId)
    {
        $store = $this->get('store.repo')->findAll();
        $store = $store[0];
        $user = $this->getUser();
        $cart = $this->get('cart.repo')->findOneBy( ['id'=>$cartId,'userId'=>$user->getId()]);

        if( $cart == NULL)
        {
            return $this->redirect($this->generateUrl('checkout_dashboard'));
        }

        if( $cart->getExpiredAt() != NULL)
        {
            echo '购物车已经过期';
        }

        $shipments = $this->get('shipment.repo')->findAll();

        $order = $this->get('order.manager')->createOrder($cart);

        if( $order == NULL)
        {
            return $this->redirect($this->generateUrl('cart_to_payment' , ['cartId' => $cartId]));
        }

        return $this->render('StoreFrontendBundle:Payment:index.html.twig' ,
            [
                'cart' => $cart ,
                'store' => $store ,
                'shipments' => $shipments ,
                'order' => $order ,
            ]
        );
    }

    public function createPaymentAction( $cartId)
    {
        $cart = $this->get('cart.repo')->find( $cartId);
        $order = $this->get('order.manager')->createOrder($cart);
        $store = $this->get('store.repo')->findAll();
        $store = $store[0];
        return new Response( $this->get('order.manager')->createPayment($order->getId(),$store->getId()) );
    }


    public function selectShipmentAction(Request $request , $cartId , $shipmentId)
    {
        $shipment = $this->get('shipment.repo')->find($shipmentId);

        if( $shipment == NULL)
        {
            return $this->redirect($this->generateUrl('cart_to_payment' , ['cartId'=>$cartId]));
        }

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $cart = $this->get('cart.repo')->findOneBy( ['id'=>$cartId,'userId'=>$user->getId()]);
        $order = $this->get('order.manager')->createOrder($cart);
        $em->persist($order);
        $order->setShipment($shipment);
        $em->flush();

        return $this->redirect($this->generateUrl('cart_to_payment' , ['cartId'=>$cartId]));
    }

    public function notifyAction(Request $request)
    {
//        echo '<pre>';
//        $sync = <<< EOF
//{"discount":"0.00","payment_type":"1","subject":"iPhone 200 x 1","trade_no":"2014090865129191","buyer_email":"seekmas@msn.cn","gmt_create":"2014-09-08 14:43:11","notify_type":"trade_status_sync","quantity":"1","out_trade_no":"199706231201409081411576030","seller_id":"2088112046306645","notify_time":"2014-09-08 14:43:19","body":"iPhone 200 x 1 <br\/>","trade_status":"TRADE_SUCCESS","is_total_fee_adjust":"N","total_fee":"0.01","gmt_payment":"2014-09-08 14:43:19","seller_email":"mwang@36lean.com","price":"0.01","buyer_id":"2088702697056914","notify_id":"30203b7f8c22ab2cef6a74cbe500b87f72","use_coupon":"N","sign_type":"MD5","sign":"99cf87b0e452e070190d71783ed6b458"}
//EOF;
//        $sync = json_decode( $sync , true);
//        foreach($sync as $key => $value)
//        {
//            $_POST[$key] = $value;
//        }

        $dispatcher = $this->get('event_dispatcher');
        $event = new CommonEvent($request,$this->container);
        $alipay_config = $this->get('order.manager')->getPaymentConfig();
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();

        if($verify_result) {//验证成功
            $dispatcher->dispatch(PaymentEvents::VARIFY_SUCCESS , $event);
            $out_trade_no = $_POST['out_trade_no'];
            $order = $this->get('order.repo')->findOneBy(['orderId'=>$out_trade_no]);

            if($order)
            {
                $this->get('order.manager')->updateOrderStatus($order,OrderStatus::OrderPaymentSuccess);
            }
            if($_POST['trade_status'] == 'TRADE_FINISHED') {
                $dispatcher->dispatch(PaymentEvents::TRADE_FINISHED , $event);
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS')
            {
                $dispatcher->dispatch(PaymentEvents::TRADE_SUCCESS , $event);
            }
            echo "success";		//请不要修改或删除
        }
        else {
            $dispatcher->dispatch(PaymentEvents::VARIFY_FAIL , $event);
            //验证失败
            echo "fail";
            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }


        return new Response();
    }

    public function returnAction( Request $request)
    {
        $store = $this->get('store.repo')->findAll();
        $store = $store[0];
        $alipay_config = $this->get('order.manager')->getPaymentConfig();
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn();

        if($verify_result) {
            $out_trade_no = $_GET['out_trade_no'];
            $order = $this->get('order.repo')->findOneBy(['orderId'=>$out_trade_no]);

            if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {

            }
            else {
                echo "trade_status=".$_GET['trade_status'];
            }

            return $this->render('StoreFrontendBundle:Payment:success.html.twig' ,
                [
                    'order'=>$order ,
                    'store' => $store
                ]
            );

        }
        else {

            return $this->render('StoreFrontendBundle:Payment:fail.html.twig' ,
                [
                    'store' => $store ,
                ]
            );
        }

        return new Response();
    }


}