<?php

namespace Store\Bundle\BackendBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MainMenuBuilder extends ContainerAware
{
    public function mainMenu( FactoryInterface $factory , array $options)
    {
        $menu = $factory->createItem('root');

        //home menu
        $menu->addChild('home',['attributes' =>['icon'=>'fa fa-shopping-cart'],'label' => '商店','route' => '']);
        $menu['home']->addChild('home_config',['attributes' =>['icon'=>'fa fa-file-text-o'],'label' => '商店信息','route' => 'store']);
        $menu['home']->addChild('create_about_us',['attributes' =>['icon'=>'fa fa-file-text-o'],'label' => '关于我们','route' => 'create_about_us']);


        //product menu
        $menu->addChild('product',['attributes' =>['icon'=>'fa fa-gift'],'label' => '产品','route' => '']);
        $menu['product']->addChild('product_manage',['attributes'=>['icon'=>'fa fa-caret-right'],'label'=>'添加/更新产品','route' => 'product_manage']);
        $menu['product']->addChild('product_trash',['attributes' =>['icon' => 'fa fa-caret-right'],'label'=>'回收站','route' => 'product_trash_manage']);

        //category menu
        $menu->addChild('category',['attributes' =>['icon' => 'fa fa-book'],'label' => '分类' ,'route' => '']);
        $menu['category']->addChild('category_manage',['attributes' =>['icon' => 'fa fa-caret-right'],'label'=>'添加/更新分类','route' => 'product_category']);
        //order menu
        $menu->addChild('order',['attributes' =>['icon' => 'fa fa-bars'],'label' => '订单' ,'route' => '']);
        $menu['order']->addChild('order_manage' , ['attributes' =>['icon' => 'fa fa-caret-right'],'label' => '订单管理' ,'route' => 'order_manage']);

        //client menu
        $menu->addChild('client',['attributes' =>['icon' => 'fa fa-users'],'label' => '顾客' ,'route' => '']);
        $menu['client']->addChild('user_manage' , ['attributes' =>['icon' => 'fa fa-caret-right'],'label' => '用户管理' ,'route' => 'user_manage']);
        $menu['client']->addChild('mail_manage' , ['attributes' =>['icon' => 'fa fa-caret-right'],'label' => '订阅管理' ,'route' => 'mail']);
        $menu['client']->addChild('sibscriber_list' , ['attributes' =>['icon' => 'fa fa-caret-right'],'label' => '订阅列表' ,'route' => 'sibscriber_list']);

        // configuration menu
        $menu->addChild('configuration',['attributes' =>['icon' => 'fa fa-cog'],'label' => '设置' ,'route' => '']);

        $menu['configuration']->addChild('bankinfo' , ['attributes' =>['icon' => 'fa fa-caret-right'],'label' => '汇款账户' ,'route' => 'bankinfo']);
        $menu['configuration']->addChild('society' , ['attributes' =>['icon' => 'fa fa-caret-right'],'label' => '社交信息' ,'route' => 'society']);
        $menu['configuration']->addChild('shipment' , ['attributes' =>['icon' => 'fa fa-caret-right'],'label' => '快递方式' ,'route' => 'shipment']);
        $menu['configuration']->addChild('product_property' , ['attributes' =>['icon' => 'fa fa-caret-right'],'label' => '商品属性' ,'route' => 'product_property']);
        $menu['configuration']->addChild('payment_manage' , ['attributes' =>['icon' => 'fa fa-caret-right'],'label' => '支付设置' ,'route' => 'payment_manage']);


        return $menu;
    }
}