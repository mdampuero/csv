<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackEndBundle\Form\Login;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;

class LoginType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', EmailType::class, array(
                'label' => 'EMAIL',
                'constraints' => array(new Email(), new NotBlank()),
                'attr' => array('autocomplete' => 'new-password', 'class' => 'form-control', 'placeholder' => 'EMAIL')
            )
            )
            ->add('_password', PasswordType::class, array(
                'label' => 'PASSWORD',
                'constraints' => array(new Length(array('min' => 6, 'max' => 32)), new NotBlank()),
                'attr' => array('autocomplete' => 'new-password', 'class' => 'form-control', 'placeholder' => 'PASSWORD')
            )
            )
            ->add('submit', SubmitType::class, array('label' => 'ENTER', 'attr' => array('class' => 'btn btn-block btn-lg btn-info btn-rounded')))
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
