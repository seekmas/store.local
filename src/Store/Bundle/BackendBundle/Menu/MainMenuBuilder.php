<?php

namespace Store\Bundle\BackendBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MainMenuBuilder extends ContainerAware
{
    public function mainMenu( FactoryInterface $factory , array $options)
    {
        $menu = $factory->createItem('root');

        /**
         * home menu
         */
        $menu->addChild('home' ,
            [
                'attributes' =>
                    [
                        'icon' => 'fa fa-file-text-o' ,
                    ] ,
                'label' => '商店信息' ,
                'route' => 'store'
            ]
        );
        /**
         * home menu
         */
        $menu->addChild('product' ,
            [
                'attributes' =>
                    [
                        'icon' => 'fa fa-file-text-o' ,
                    ] ,
                'label' => '产品信息' ,
                'route' => ''
            ]
        );
        /**
         * home menu
         */
        $menu->addChild('category' ,
            [
                'attributes' =>
                    [
                        'icon' => 'fa fa-file-text-o' ,
                    ] ,
                'label' => '产品分类' ,
                'route' => ''
            ]
        );
        /**
         * home menu
         */
        $menu->addChild('order' ,
            [
                'attributes' =>
                    [
                        'icon' => 'fa fa-file-text-o' ,
                    ] ,
                'label' => '订单' ,
                'route' => ''
            ]
        );
        /**
         * client menu
         */
        $menu->addChild('client' ,
            [
                'attributes' =>
                    [
                        'icon' => 'fa fa-file-text-o' ,
                    ] ,
                'label' => '顾客' ,
                'route' => ''
            ]
        );
        /**
         * configuration menu
         */
        $menu->addChild('configuration' ,
            [
                'attributes' =>
                [
                    'icon' => 'fa fa-file-text-o' ,
                ] ,
                'label' => '设置' ,
                'route' => '' ,
            ]
        );
        /**
         * home menu
         */
        $menu['product']
        ->addChild('product_manage' ,
            [
                'attributes' =>
                    [
                        'icon' => 'fa fa-caret-right' ,
                    ] ,
                'label' => '添加/更新' ,
                'route' => 'product_manage' ,
            ]
        );

        $menu['product']->addChild('product_trash' ,
                [
                    'attributes' =>
                        [
                            'icon' => 'fa fa-caret-right' ,
                        ] ,
                    'label' => '回收站' ,
                    'route' => 'product_trash_manage' ,
                ]
        );



        return $menu;
    }
}