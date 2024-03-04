<?php

namespace App\Form;

use App\Entity\Calendar;
use App\Entity\MoyTransport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\EntityManagerInterface;

class CalendarType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Veuillez fournir un titre.']),
                new Length([
                    'min' => 3,
                    'max' => 100,
                    'minMessage' => 'Le titre doit contenir au moins {{ limit }} caractères.',
                    'maxMessage' => 'Le titre ne peut pas contenir plus de {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('start', DateTimeType::class, [
            'date_widget' => 'single_text'
        ])
        ->add('end', DateTimeType::class, [
            'date_widget' => 'single_text'
        ])
        ->add('description', TextareaType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Veuillez fournir une description pour la réservation.']),
                new Length([
                    'min' => 5,
                    'max' => 100,
                    'minMessage' => 'La description de la réservation doit contenir au moins {{ limit }} caractères.',
                    'maxMessage' => 'La description de la réservation ne peut pas contenir plus de {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('all_day')
        ->add('passenger_count', IntegerType::class, [
            'constraints' => [
                new NotBlank(),
                new Type('integer'),
            ],
        ])
        ->add('transport', EntityType::class, [
            'class' => MoyTransport::class,
            'choice_label' => 'transport_model',
            'constraints' => [
                new NotBlank(),
                new Callback([$this, 'validateTransport']),
            ],
        ])
        ->add('background_color', ColorType::class)
        ->add('border_color', ColorType::class)
        ->add('text_color', ColorType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Calendar::class,
        ]);
    }

    public function validateTransport($value, ExecutionContextInterface $context)
    {
        $transport = $this->entityManager->getRepository(MoyTransport::class)->find($value);

        if (!$transport) {
            $context->buildViolation('Invalid transport selected.')
                ->atPath('transport')
                ->addViolation();
        }
    }
}
