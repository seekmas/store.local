<?php

namespace Store\Bundle\BackendBundle\Controller;


use Store\Bundle\BackendBundle\Controller\CoreController as Controller;

use Store\Bundle\BackendBundle\Entity\Property;
use Store\Bundle\BackendBundle\Form\Type\PropertyType;
use Symfony\Component\HttpFoundation\Request;

class ProductPropertyController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $property = new Property();
        $em->persist($property);
        $form = $this->createNewForm($request , new PropertyType() , $property);

        if( $form->isValid())
        {
            $data = $form->getData();
            if( $isExist = $this->get('property.repo')->findOneBy(['propertyName'=>$data->getPropertyName()]))
            {
                $this->addFlashMessage('danger' , '属性已经存在了 不用重复添加');
                return $this->redirect($this->generateUrl('product_property'));
            }
            $em->flush();
            $this->addFlashMessage('success' , '属性添加成功');
            return $this->redirect($this->generateUrl('product_property'));
        }

        $properties = $this->get('property.repo')->findAll();


        return $this->render('StoreBackendBundle:ProductProperty:index/index.html.twig' ,
            [
                'properties' => $properties ,
                'form' => $form->createView()
            ]
        );
    }


}