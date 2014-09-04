<?php

namespace Store\Bundle\BackendBundle\Controller;


use Doctrine\ORM\EntityNotFoundException;
use Store\Bundle\BackendBundle\Entity\Category;
use Store\Bundle\BackendBundle\Form\Type\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    public function indexAction(Request $request)
    {

        $user = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $store = $this->get('store.repo')->findOneBy(['userId' => $user->getId()]);

        $category = new Category();

        $em->persist($category);

        $form = $this->createNewForm( $request , new CategoryType() , $category );

        if( $form->isValid())
        {

            if( $this->get('category.repo')->findOneBy(['store' => $store->getId() , 'name' => $category->getName()]) )
            {
                $request->getSession()->getFlashBag()->add('warning' , '产品分类 [ '.$category->getName().' ] 已经存在！' );
                return $this->redirect(
                    $this->generateUrl('product_category')
                );
            }

            $category->setStore( $store);
            $category->setCreatedAt( new \Datetime() );

            $em->flush();

            $request->getSession()->getFlashBag()->add('success' , '产品分类添加成功' );

            return $this->redirect(
                $this->generateUrl('product_category')
            );
        }

        $categories = $this->get('category.repo')->findBy(['storeId' => $store->getId()]);

        return $this->render('StoreBackendBundle:Category:index/index.html.twig' ,
            [
                'categories' => $categories ,
                'form' => $form->createView() ,
            ]
        );
    }

    public function editAction( Request $request , $id)
    {
        $category = $this->get('category.repo')->find( $id);

        if( $category == NULL)
        {
            throw new EntityNotFoundException();
        }

        $form = $this->createNewForm( $request , new CategoryType() , $category);

        if( $form->isValid())
        {
            $data = $form->getData();
        }

        return $this->render('StoreBackendBundle:Category:edit/index.html.twig' ,
            [
                'category' => $category ,
                'form'     => $form->createView() ,
            ]
        );

    }

    protected function createNewForm( Request $request , $formType , $entity)
    {
        $form = $this->createForm( $formType , $entity );
        $form->handleRequest( $request);
        return $form;
    }
}