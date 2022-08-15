<?php

namespace App\Form;

use App\Entity\Brand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Brand name',
                'attr' => [
                    'minlength' => 8,
                    'maxlength' => 40
                ]
            ])
            ->add('image', TextType::class,[
                'label' => 'Brand image',
                'attr' => [
                    'maxlength' => 225
                ]
            ])
            ->add('telephone', TextType::class,[
                'label' => 'Brand phonenumber',
                'attr' => [
                    'minlength' => 12,
                    'maxlength' => 20
                ]
            ])
            ->add('email', TextType::class,[
                'label' => 'Brand email',
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
            'data_class' => Brand::class,
        ]);
    }
}
