<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Category name',
                'attr' => [
                    'minlength' => 5,
                    'maxlength' => 40
                ]
            ])
            ->add('image', TextType::class,[
                'label' => 'Category image',
                'attr' => [
                    'maxlength' => 225
                ]
            ])
            ->add('description', TextType::class,[
                'label' => 'Category description',
                'attr' => [
                    'minlength' => 30,
                    'maxlength' => 500
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
