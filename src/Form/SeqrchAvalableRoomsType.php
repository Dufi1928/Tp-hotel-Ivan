<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeqrchAvalableRoomsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('checkInDate', DateType::class, [
                'label' => 'Start Date',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => [
                    'class' => 'form-control datepicker-input',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('checkOutDate', DateType::class, [
                'label' => 'End Date',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => [
                    'class' => 'form-control datepicker-input',
                    'autocomplete' => 'off'
                ]
            ])

            ->add('beds', IntegerType::class, [
                'label' => 'Nombre de lits',
            ])

            ->add('city', TextType::class, [
                'label' => 'City',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('search', SubmitType::class, [
                'label' => 'Rechercher',
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
