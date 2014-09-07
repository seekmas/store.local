<?php

namespace Store\Bundle\BackendBundle\Cart;

use Store\Bundle\BackendBundle\Entity\Product;
use Store\Bundle\BackendBundle\Entity\CartItem;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Store\Bundle\BackendBundle\Entity\Cart as CartEntity;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;


class Cart implements CartInterface
{
    protected $cart;
    protected $service_container;

    public function __construct(ContainerInterface $service_container)
    {
        $this->service_container = $service_container;
    }

    public function getCart()
    {
        $em = $this->get('doctrine')->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        if( $user == 'anon.')
        {
            throw new UnsupportedUserException();
        }

        $cart = $this->get('cart.repo')->findOneBy(['userId'=>$user->getId()]);

        if( $cart == NULL)
        {
            $cart = new CartEntity();
            $em->persist($cart);
            $cart->setUserId( $user->getId() );
            $cart->setCreatedAt( new \Datetime());
            $em->flush();
        }

        $this->cart = $cart;

        return $cart;
    }

    public function getItems()
    {

    }

    public function addProduct(Product $product , $params = [])
    {
        $em = $this->get('doctrine')->getManager();
        $item = new CartItem();
        $em->persist($item);

        $item->setProductBasket($product->getProductBasket());
        $item->setCart($this->getCart());

        $item->setSum(1);
        $item->setSinglePrice($product->getProductPrice());
        $item->setTotalPrice($product->getProductPrice());
        $item->setParams(json_encode( $params ));
        $item->setCreatedAt( new \Datetime());

        $em->flush();
    }

    public function removeItem()
    {
        // TODO: Implement removeItem() method.
    }

    protected function get($service)
    {
        if( $this->service_container->has($service))
        {
            return $this->service_container->get($service);
        }else
        {
            throw new ServiceNotFoundException($service);
        }
    }

}
