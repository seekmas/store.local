<?php

namespace Store\Bundle\FrontendBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Store\Bundle\BackendBundle\Cart\OrderStatus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    public function indexAction($categoryId = 0 , $tagId = 0)
    {

        $store = $this->get('store.repo')->findAll();

        if( $store == NULL)
        {
            return $this->render('StoreFrontendBundle:Home:under_construction.html.twig');
        }

        $standardStore = $store[0];

        if( $categoryId > 0)
        {
            $pagination = $this->get('productBasket.paginator')
                ->setCondition( ['storeId' => $standardStore->getId()  , 'categoryId' => $categoryId] )
                ->createPagination();
        }
        else if( $tagId > 0)
        {
            $tag = $this->get('tag.repo')->find($tagId);
            $pagination = $tag->getProductBasket();
        }
        else
        {
            $pagination = $this->get('productBasket.paginator')
                ->setCondition( ['storeId' => $standardStore->getId()] )
                ->createPagination();
        }

        $tags = $this->get('tag.repo')->findAll();

        $category = $this->get('category.repo')->find( $categoryId);
        $tag = $this->get('tag.repo')->find( $tagId);

        return $this->render('StoreFrontendBundle:Home:index.html.twig',
            [
                'store'      => $standardStore ,
                'products'   => $pagination ,
                'tags'       => $tags ,
                'category'   => $category ,
                'tag'        => $tag
            ]
        );
    }

    public function productAction( Request $request , $id)
    {

        $product = $this->get('product.repo')->find( $id);

        if( $product == NULL)
        {
            throw new EntityNotFoundException();
        }

        return $this->render('StoreFrontendBundle:Home:product/product.html.twig' ,
               [
                   'product' => $product
               ]
        );
    }

    public function shipmentAction()
    {
        $user = $this->getUser();
        $store = $this->get('store.repo')->findAll();

        if( $store == NULL)
        {
            return $this->render('StoreFrontendBundle:Home:under_construction.html.twig');
        }

        $store = $store[0];

        $orders = $this->get('order.repo')->findBy(
            [
                'userId' => $user->getId() ,
            ]
        );

        return $this->render('StoreFrontendBundle:Home:shipment/index.html.twig' ,
            [
                'store' => $store ,
                'orders' => $orders ,
            ]
        );
    }

    public function confirmAction(Request $request , $id)
    {

        $store = $this->get('store.repo')->findAll();

        if( $store == NULL)
        {
            return $this->render('StoreFrontendBundle:Home:under_construction.html.twig');
        }

        $store = $store[0];

        return $this->render('StoreFrontendBundle:Home:confirm/confirm.html.twig' ,
            [
                'store'     => $store ,
                'orderId'   => $id ,
            ]
        );
    }

    public function confirmedAction(Request $request , $id)
    {
        $store = $this->get('store.repo')->findAll();
        $user = $this->getUser();
        if( $store == NULL)
        {
            return $this->render('StoreFrontendBundle:Home:under_construction.html.twig');
        }

        $order = $this->get('order.repo')->findOneBy(['userId'=>$user->getId() , 'id'=>$id]);

        $this->get('order.manager')->updateOrderStatus($order,OrderStatus::OrderInvoiceCreated);

        $request->getSession()->getFlashBag()->add('success' , '确认收货成功');

        return $this->redirect($this->generateUrl('shipment_dashboard'));
    }
}
