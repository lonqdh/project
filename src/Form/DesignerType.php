<?php

namespace App\Form;

use App\Entity\Designer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DesignerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Designer full name',
                'attr' => [
                    'minlength' => 10,
                    'maxlength' => 35
                ]
            ])
            ->add('image', TextType::class,[
                'label' => 'Designer image',
                'attr' => [
                    'maxlength' => 255
                ]
            ])
            ->add('email', TextType::class,[
                'label' => 'Designer email address',
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
            'data_class' => Designer::class,
        ]);
    }
}
