<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Designer;
use App\Entity\Material;
use App\Entity\Manufacturer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Product name',
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 40
                ]
            ])
            ->add('image', TextType::class,[
                'label' => 'Product image',
                'attr' => [
                    'maxlength' => 225
                ]
            ])
            ->add('description', TextType::class,[
                'label' => 'Product description',
                'attr' => [
                    'minlength' => 8,
                    'maxlength' => 100
                ]
            ])
            ->add('quantity', IntegerType::class,[
                'label' => 'Product quantity',
                'attr' => [
                    'min' => 1,
                    'max' => 1000
                ]
            ])
            ->add('price', MoneyType::class,[
                'label' => 'Product price',
                'currency'=> 'USD'
            ])
            ->add('size', ChoiceType::class,[
                'label' => 'Product size',
                'choices' => [
                    "S"=> "S",
                    "M"=> "M",
                    "L"=> "L",
                    "XL"=> "XL"
                ]
            ])


            ->add('manufacturer', EntityType::class,[
                'label' => 'Manufacturer',
                'required' => true,
                'class' => Manufacturer::class,
                'choice_label' => 'name',
                'multiple' => false,  
                'expanded' => false
            ])
            ->add('designer', EntityType::class,[
                'label' => 'Designer',
                'required' => true,
                'class' => Designer::class,
                'choice_label' => 'name',
                'multiple' => false,  
                'expanded' => false
            ])
            ->add('brand', EntityType::class,[
                'label' => 'Brand',
                'required' => true,
                'class' => Brand::class,
                'choice_label' => 'name',
                'multiple' => false, 
                'expanded' => false
            ])
            ->add('material', EntityType::class,[
                'label' => 'Material',
                'required' => true,
                'class' => Material::class,
                'choice_label' => 'name',
                'multiple' => true,  
                'expanded' => false
            ])
            ->add('category', EntityType::class,[
                'label' => 'Category',
                'required' => true,
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => false, 
                'expanded' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
