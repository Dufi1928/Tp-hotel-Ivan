<?php

namespace App\Form;

use App\Entity\Suite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('imageName')
            ->add('price')
            ->add('updatedAt')
            ->add('beds')
            ->add('bathroom')
            ->add('size')
            ->add('hotel')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Suite::class,
        ]);
    }
}
