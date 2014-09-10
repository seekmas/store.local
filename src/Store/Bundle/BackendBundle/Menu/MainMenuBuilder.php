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
        $menu->addChild('home',['attributes' =>['icon'=>'fa fa-file-text-o'],'label' => '商店信息','route' => 'store']);
        //product menu
        $menu->addChild('product',['attributes' =>['icon'=>'fa fa-file-text-o'],'label' => '产品信息','route' => '']);
        $menu['product']->addChild('product_manage',['attributes'=>['icon'=>'fa fa-caret-right'],'label'=>'添加/更新产品','route' => 'product_manage']);
        $menu['product']->addChild('product_trash',['attributes' =>['icon' => 'fa fa-caret-right'],'label'=>'回收站','route' => 'product_trash_manage']);

        //category menu
        $menu->addChild('category',['attributes' =>['icon' => 'fa fa-file-text-o'],'label' => '产品分类' ,'route' => '']);
        $menu['category']->addChild('category_manage',['attributes' =>['icon' => 'fa fa-caret-right'],'label'=>'添加/更新分类','route' => 'product_category']);
        //order menu
        $menu->addChild('order',['attributes' =>['icon' => 'fa fa-file-text-o'],'label' => '订单' ,'route' => '']);
        $menu['order']->addChild('order_manage' , ['attributes' =>['icon' => 'fa fa-caret-right'],'label' => '订单管理' ,'route' => 'order_manage']);



        //client menu
        $menu->addChild('client',['attributes' =>['icon' => 'fa fa-file-text-o'],'label' => '顾客' ,'route' => '']);
        $menu['client']->addChild('user_manage' , ['attributes' =>['icon' => 'fa fa-caret-right'],'label' => '用户管理' ,'route' => 'user_manage']);
        $menu['client']->addChild('mail_manage' , ['attributes' =>['icon' => 'fa fa-caret-right'],'label' => '订阅管理' ,'route' => 'mail']);

        // configuration menu
        $menu->addChild('configuration',['attributes' =>['icon' => 'fa fa-file-text-o'],'label' => '设置' ,'route' => '']);
        $menu['configuration']->addChild('shipment' , ['attributes' =>['icon' => 'fa fa-caret-right'],'label' => '快递方式' ,'route' => 'shipment']);
        $menu['configuration']->addChild('product_property' , ['attributes' =>['icon' => 'fa fa-caret-right'],'label' => '商品属性' ,'route' => 'product_property']);
        $menu['configuration']->addChild('payment_manage' , ['attributes' =>['icon' => 'fa fa-caret-right'],'label' => '支付设置' ,'route' => 'payment_manage']);



        return $menu;
    }
}