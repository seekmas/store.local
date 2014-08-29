<?php

namespace Store\Bundle\BackendBundle\Form\Type;

use Store\Bundle\BackendBundle\Form\Factory\BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComplexProductType extends BaseType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder , $options);

        $builder
            ->add('productName')
            ->add('productAlias')
            ->add('photo' , 'file' , array('required' => false ))
            ->add('productDesc')
            ->add('productPrice')
            ->add('isAvailable')
        ;

        $builder->add('submit' , 'submit');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\Bundle\BackendBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'store_bundle_backend_bundle_product';
    }
}
