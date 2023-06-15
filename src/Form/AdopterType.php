<?php

namespace App\Form;

use App\Entity\Adopter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdopterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', 
            EmailType::class,
            [
                'required' => true,
            ]
            )
            ->add('firstName',
            TextType::class,
            [
                'required' => true,
            ])
            ->add('lastName',
            TextType::class,
            [
                'required' => true,
            ])
            ->add('city',
            TextType::class,
            [
                'required' => true,
            ])
            ->add('department',
            TextType::class,
            [
                'required' => true,
            ])
            ->add('phone')
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adopter::class,
        
        ]);
    }
}
