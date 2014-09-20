<?php

namespace Store\Bundle\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BankInfoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('account' , 'text' , ['label'=>'我的银行卡号'])
            ->add('bankname' , 'text' , ['label'=>'我的开户银行'])
            ->add('name' , 'text' , ['label'=>'我的名字'])
        ;
        $builder->add('submit','submit',['label'=>'更新']);
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\Bundle\BackendBundle\Entity\BankInfo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'store_bundle_backendbundle_bankinfo';
    }
}
