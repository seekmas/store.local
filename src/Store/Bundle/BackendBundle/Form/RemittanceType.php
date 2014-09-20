<?php

namespace Store\Bundle\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RemittanceType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name' , 'text' , ['label'=>'我的名字'])
            ->add('bank' , 'text' , ['label'=>'我的开户银行'])
            ->add('account' , 'text' , ['label'=>'银行卡号'])
            ->add('contact' , 'text' , ['label'=>'联系方式 ( 手机号/QQ号/邮箱 任选一个联系方式 )'])
        ;
        $builder->add('submit' , 'submit' , ['label'=>'更新']);
    }

    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Store\Bundle\BackendBundle\Entity\Remittance'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'store_bundle_backendbundle_remittance';
    }
}
