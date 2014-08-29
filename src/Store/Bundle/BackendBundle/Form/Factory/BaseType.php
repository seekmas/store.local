<?php

namespace Store\Bundle\BackendBundle\Form\Factory;

use Store\Bundle\BackendBundle\EventSubscriber\FormInitializationSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BaseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $subscriber = new FormInitializationSubscriber();
        $builder->addEventSubscriber($subscriber);

        parent::buildForm( $builder , $options);
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'store_base_type';
    }
}
