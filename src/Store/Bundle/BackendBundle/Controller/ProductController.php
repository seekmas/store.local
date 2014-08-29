<?php

namespace Store\Bundle\BackendBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Store\Bundle\BackendBundle\Entity\Product;
use Store\Bundle\BackendBundle\Entity\ProductBasket;
use Store\Bundle\BackendBundle\Form\Type\ComplexProductType;
use Store\Bundle\BackendBundle\Form\Type\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $dispatcher = $this->get('event_dispatcher');

        $product = new Product();
        $em->persist( $product);
        $form = $this->createNewForm( $request , new ProductType() , $product );

        if( $form->isValid() )
        {
            $product->setCreatedAt( new \DateTime());

            $productBasket = new ProductBasket();
            $em->persist( $productBasket);
            $productBasket->setCreatedAt( new \DateTime());
            $productBasket->setProduct( $product );
            $productBasket->setUser( $user);

            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    'product_manage'
                )
            );
        }

        return $this->render('StoreBackendBundle:Product:index.html.twig' ,
            [
                'form' => $form->createView() ,
                'user' => $user ,
            ]
        );
    }

    public function editAction(Request $request , $id)
    {

        $em = $this->getDoctrine()->getManager();

        $product = $this->get('product.repo')->find( $id);

        $em->persist( $product );

        if( $product === NULL)
        {
            throw new EntityNotFoundException();
        }

        if( $product->getPhoto() )
        {
            $tmp_photo = $product->getPhoto();
            $product->setPhoto(NULL);
        }else
        {
            $tmp_photo = NULL;
        }

        $form = $this->createNewForm( $request , new ComplexProductType() , $product);

        if( $form->isValid() )
        {

            $data = $form->getData();

            $photo = $data->getPhoto();

            if( $photo)
            {
                if( $tmp_photo)
                {
                    $this->get('file.save')->remove( $tmp_photo);
                }

                $photo = $this->get('file.save')->save( $photo , 'product' );

                $product->setPhoto( $photo );

            }else
            {
                $product->setPhoto( $tmp_photo);
            }

            $em->flush();

            return $this->redirect(
                $this->generateUrl( 'product_edit' , ['id' => $id] )
            );

        }

        $product->setPhoto( $tmp_photo);
        return $this->render('StoreBackendBundle:Product:edit.html.twig' ,
            [
                'product' => $product ,
                'form' => $form->createView() ,
            ]
        );
    }


    protected function createNewForm(Request $request , AbstractType $type , $entity)
    {
        $form = $this->createForm( $type , $entity );
        $form->handleRequest( $request );
        return $form;
    }
}