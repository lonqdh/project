<?php

namespace App\Form;

use App\Entity\Manufacturer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ManufacturerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Manufacturer name',
                'attr' => [
                    'minlength' => 5,
                    'maxlength' => 35
                ]
            ])
            ->add('image', TextType::class,[
                'label' => 'Manufacturer image',
                'attr' => [
                    'maxlength' => 255
                ]
            ])
            ->add('email', TextType::class,[
                'label' => 'Manufacturer email',
                'attr' => [
                    'minlength' => 12,
                    'maxlength' => 40
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manufacturer::class,
        ]);
    }
}
