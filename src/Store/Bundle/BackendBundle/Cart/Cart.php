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

        $query = $this->get('cart.repo')
                     ->createQueryBuilder('cart')
                     ->select('cart')
                     ->where('cart.userId = '.$user->getId())
                     ->AndWhere('cart.expiredAt is NULL')
                     ->getQuery();

        $cart = $query->getOneOrNullResult();

        if( $cart == NULL)
        {
            $cart = new CartEntity();
            $em->persist($cart);
            $cart->setUser( $user );
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

        $cart = $this->getCart();

        $item = new CartItem();
        $em->persist($item);

        $item->setProductBasket($product->getProductBasket());
        $item->setCart( $cart);

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
