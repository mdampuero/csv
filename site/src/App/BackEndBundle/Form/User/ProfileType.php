<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackEndBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class ProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'NAME', 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control', 'placeholder' => 'NAME')))
            ->add('email', TextType::class, array('label' => 'EMAIL', 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control', 'placeholder' => 'EMAIL')))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'constraints' => array(new Length(array('min' => 6, 'max' => 32))),
                'first_options' => array('label' => 'PASSWORD', 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control')),
                'second_options' => array('label' => 'REPEAT_PASSWORD', 'label_attr' => array('class' => 'control-label'), 'attr' => array('class' => 'form-control')),
            )
            );

        $builder
            ->add('pictureRemove', HiddenType::class, array("mapped" => false))
            ->add('pictureBase64', HiddenType::class, array("mapped" => false))
            ->add(
                'picture',
                FileType::class,
                array(
                    'label' => 'PHOTO',
                    'data_class' => null,
                    'label_attr' => array('class' => 'control-label'),
                    'attr' => array(
                        'onchange' => 'encodeImageFileAsURL(this)',
                        'class' => 'dropify',
                        'data-height' => '300',
                        'data-max-file-size' => '2M',
                        'data-allowed-file-extensions' => 'png jpg jpeg gif'
                    )
                )
            )
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
                'data_class' => 'App\BackEndBundle\Entity\User'
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
