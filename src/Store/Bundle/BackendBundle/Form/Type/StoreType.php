<?php

namespace Store\Bundle\BackendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StoreType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('logo' , 'file' , array('required' => false ))
            ->add('name')
            ->add('city')
            ->add('address')
            ->add('extraInfo' , 'textarea' , array('label' => '网站备案信息' , 'required' => false ))
            ->add('smtpUser')
            ->add('smtpPassword')
            ->add('smtpAddress')
            ->add('smtpPort')
        ;

        $builder->add('submit' , 'submit');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\Bundle\BackendBundle\Entity\Store'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'store_bundle_backendbundle_store';
    }
}
