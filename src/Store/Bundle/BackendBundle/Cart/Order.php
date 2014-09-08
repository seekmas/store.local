<?php

namespace Store\Bundle\BackendBundle\Cart;

use Store\Bundle\BackendBundle\Entity\Cart;
use Store\Bundle\BackendBundle\Entity\Orders;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Service;
use Store\Bundle\BackendBundle\Exception\AddressNotFoundException;


/**
 * @Service("order.manager")
 */
class Order implements OrderInterface
{
    private $_em;
    private $_security;
    private $_service_container;
    private $_format;

    /**
     * @DI\InjectParams(
     *  {
     *      "em"         = @DI\Inject("doctrine.orm.entity_manager"),
     *      "security"   = @DI\Inject("security.context"),
     *      "service_container" = @DI\Inject("service_container")
     *  }
     * )
     */
    public function __construct($em , $security , $service_container)
    {
        $this->_em = $em;
        $this->_security = $security;
        $this->_service_container = $service_container;
        $this->_format = 'json';
    }

    public function createOrder($cart)
    {
        $em = $this->_em;
        $user = $this->_security->getToken()->getUser();
        $serializer = $this->get('jms_serializer');
        $address = $this->get('address.repo')->findOneBy(['userId'=>$user->getId(),'isDefault'=>true]);
        $cost =  0;
        $description = '';

        foreach( $cart->getCartItem() as $item)
        {
            if( $item->getRemovedAt() == NULL)
            {
                $cost += $item->getTotalPrice();
                $description .= $item->getProductBasket()->getProduct()->getProductName().' x '.$item->getSum().' <br/>';
            }
        }

        $order = $this->get('order.repo')->findOneBy(
            [
                'cartId' => $cart->getId() ,
                'isLocked' => false ,
            ]
        );

        if( $order)
        {
            $em = $this->_em;
            if( $order->getAddress() == NULL || ($address->getId() != $order->getAddress()->getId()) )
            {
                $order->setAddress( $address);
            }
            $order->setDescription($description);
            $order->setTotalCost($cost);
            $em->persist($order);
            $em->flush();
            return $order;
        }

        if( $address == NULL)
        {
            throw new AddressNotFoundException();
        }

        $order = new Orders();

        $orderId = '19970623'.( $user->getId() . date('YmdHis') . mt_rand(1000,9999) );
        $order->setOrderId($orderId);
        $order->setDescription(description);
        $order->setTotalCost($cost);
        $order->setCart($cart);
        $order->setUser($user);
        $order->setAddress($address);
        $order->setAlipayParams( $serializer->serialize([] , $this->getFormat()));
        $order->setIsLocked(false);
        $order->setPaymentStatus(OrderStatus::OrderCreated);
        $order->setCreatedAt(new \Datetime());
        $order->setIsLocked(false);

        $order->setPaymentStatus(OrderStatus::OrderCreated);
        $em->persist($order);
        $em->flush();
    }

    public function createPayment($orderId , $storeId)
    {
        $order = $this->get('order.repo')->find($orderId);
        $payment = $this->get('alipay.repo')->findOneBy(['isDefault' => 1, 'storeId' => $storeId]);

        if( $payment == NULL)
        {
            echo '缺少支付参数 请联系站长';
            exit;
        }

        //合作身份者id，以2088开头的16位纯数字
        $alipay_config['partner']		= $payment->getPartnerId();

        //安全检验码，以数字和字母组成的32位字符
        $alipay_config['key']			= $payment->getPartnerKey();

        //签名方式 不需修改
        $alipay_config['sign_type']    = strtoupper('MD5');

        //字符编码格式 目前支持 gbk 或 utf-8
        $alipay_config['input_charset']= strtolower('utf-8');

        //ca证书路径地址，用于curl中ssl校验
        //请保证cacert.pem文件在当前文件夹目录中
        $alipay_config['cacert']    = $this->get('kernel')->getRootDir().'/../vendor/mot/alipay/cacert.pem';

        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $alipay_config['transport']    = 'http';

        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = $this->get('router')->generate('alipay_notify');
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = $this->get('router')->generate('alipay_notify');
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //卖家支付宝帐户
        $seller_email = $payment->getAccount();
        //必填

        //商户订单号
        $out_trade_no = $order->getOrderId();
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        $subject = strip_tags( $order->getDescription() );
        //必填

        //付款金额
        $total_fee = $order->getTotalCost() + $order->getShipment()->getShipmentPrice();

        $body = $order->getDescription();
        //商品展示地址
        $show_url = $this->get('router')->generate('index');
        //需以http://开头的完整路径，例如：http://www.xxx.com/myorder.html

        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数

        //客户端的IP地址
        $exter_invoke_ip = "";
        //非局域网的外网IP地址，如：221.0.0.1


        /************************************************************/

        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($payment->getPartnerId()),
            "payment_type"	=> $payment_type,
            "notify_url"	=> $notify_url,
            "return_url"	=> $return_url,
            "seller_email"	=> $seller_email,
            "out_trade_no"	=> $out_trade_no,
            "subject"	=> $subject,
            "total_fee"	=> $total_fee,
            "body"	=> $body,
            "show_url"	=> $show_url,
            "anti_phishing_key"	=> $anti_phishing_key,
            "exter_invoke_ip"	=> $exter_invoke_ip,
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
        );


        //建立请求
        $alipaySubmit = new \AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
    }

    public function updateOrderStatue($orderId, OrderStatus $status_code)
    {
        // TODO: Implement updateOrderStatue() method.
    }

    public function setOrder(Orders $order)
    {
        // TODO: Implement setOrder() method.
    }

    public function getOrder()
    {
        // TODO: Implement getOrder() method.
    }

    public function getAllOrders()
    {
        // TODO: Implement getAllOrders() method.
    }

    /**
     * @param string $format
     * @return Order
     */
    public function setFormat($format)
    {
        $this->_format = $format;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->_format;
    }

    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }

    public function get($service)
    {
        if( $this->_service_container->has($service))
            return $this->_service_container->get($service);
        else
            return ;
    }
}