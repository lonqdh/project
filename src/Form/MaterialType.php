<?php

namespace App\Form;

use App\Entity\Material;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'required' => true,
                'label' => 'Material name',
                'attr' => [
                    'minlength' => 5,
                    'maxlength' => 20
                ]
            ])
            ->add('color', TextType::class,
            [
                'required' => true,
                'label' => 'Color name',
                'attr' => [
                    'minlength' => 5,
                    'maxlength' => 20
                ]
            ])
            ->add('texture', TextType::class,
            [
                'required' => true,
                'label' => 'Texture name',
                'attr' => [
                    'minlength' => 5,
                    'maxlength' => 20
                ]
            ])
            ->add('fabric', TextType::class,
            [
                'required' => true,
                'label' => 'Fabric name',
                'attr' => [
                    'minlength' => 5,
                    'maxlength' => 20
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Material::class,
        ]);
    }
}
