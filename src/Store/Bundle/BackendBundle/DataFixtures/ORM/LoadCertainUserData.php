<?php

namespace Store\Bundle\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Store\Bundle\BackendBundle\Entity\Product;


class LoadCertainUserData implements FixtureInterface
{
    function load(ObjectManager $manager)
    {
//        $product = new Product();
//
//        $product->setProductName( '新产品' . mt_rand(0,9999) );
//        $product->setProductAlias( 'new-product-' . mt_rand(0,9999) );
//        $product->setCreatedAt( new \Datetime());
//        $product->setProductDesc( 'Some introduction');
//        $product->setProductPrice( 3999.99 );
//
//        $manager->persist($product);
//        $manager->flush();
    }
}