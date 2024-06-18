<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackEndBundle\Form\Setting;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SettingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'TITLE', 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control', 'placeholder' => 'TITLE')))
            ->add('copyright', TextType::class, array('label' => 'COPYRIGHT', 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control', 'placeholder' => 'TITLE')))
        ;
    } /**
      * {@inheritdoc}
      */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'csrf_protection' => false,
                'allow_extra_fields' => true,
                'data_class' => 'App\BackEndBundle\Entity\Setting'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }


}
