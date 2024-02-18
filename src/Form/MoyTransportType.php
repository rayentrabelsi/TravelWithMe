<?php

namespace App\Form;

use App\Entity\MoyTransport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Validator\Constraints\NotNull;


class MoyTransportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
    
        ->add('transport_model', TextType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Le modèle de transport est requis.']),
                new Length([
                    'min' => 2,
                    'max' => 100,
                    'minMessage' => 'Le modèle de transport doit contenir au moins {{ limit }} caractères.',
                    'maxMessage' => 'Le modèle de transport ne peut pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('transport_price', NumberType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Le prix de transport est requis.']),
                new PositiveOrZero(['message' => 'Le prix de transport doit être un nombre positif ou zéro.']),
            ],
        ])
        ->add('transport_description', TextareaType::class, [
            'constraints' => [
                new NotBlank(['message' => 'La description du transport est requise.']),
                new Length([
                    'min' => 10,
                    'max' => 500,
                    'minMessage' => 'La description du transport doit contenir au moins {{ limit }} caractères.',
                    'maxMessage' => 'La description du transport ne peut pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('disponibility', ChoiceType::class, [
            'choices' => [
                'Disponible' => true,
                'Non disponible' => false,
            ],
            'constraints' => [
                new NotNull(['message' => 'La disponibilité du transport est requise.']),
            ],
        ])
            ->add('Transport_Picture', FileType::class, [
                'label' => 'Transport_Picture',
                'required' => false,
                'data_class' => null,
                'attr' => [
                    'accept' => 'image/*', 
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MoyTransport::class,
        ]);
    }
}
