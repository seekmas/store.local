<?php
namespace Store\Bundle\BackendBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CoreController extends Controller
{

    protected function createNewForm( Request $request , $formType , $entity)
    {
        $form = $this->createForm( $formType , $entity );
        $form->handleRequest( $request);
        return $form;
    }

    protected function addFlashMessage($type,$message)
    {
        $request = $this->getRequest();
        $request->getSession()->getFlashBag()->add($type,$message);
    }


    public function __call($func,$arguments){}
    public function __toString(){ return 'controller';}
}