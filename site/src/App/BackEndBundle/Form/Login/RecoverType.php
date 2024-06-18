<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackEndBundle\Form\Login;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class RecoverType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'constraints' => array(new NotBlank(), new Length(array('min' => 6, 'max' => 32))),
                'first_options' => array('label' => 'NEW_PASSWORD', 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control')),
                'second_options' => array('label' => 'REPEAT_NEW_PASSWORD', 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control')),
            )
            )
            ->add('submit', SubmitType::class, array('label' => 'RESET_PASSWORD', 'attr' => array('class' => 'btn btn-info btn-lg btn-block waves-effect waves-light')))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => null
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
