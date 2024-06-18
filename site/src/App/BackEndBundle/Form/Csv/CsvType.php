<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackEndBundle\Form\Csv;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class CsvType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('file', FileType::class, array(
            'label' => 'CSV File',
            'label_attr' => array('class' => 'control-label'),
            'attr' => array('class' => 'form-control'),
            'constraints' => array(
                new NotBlank(),
                new File(array(
                    'maxSize' => '5M',
                    'mimeTypes' => array(
                        'text/csv',
                        'text/plain',
                        'application/vnd.ms-excel',
                    ),
                    'mimeTypesMessage' => 'Please upload a valid CSV file',
                ))
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'=>false,
            'allow_extra_fields'=>true,
            'data_class' => 'App\BackEndBundle\Entity\Csv'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }

}
