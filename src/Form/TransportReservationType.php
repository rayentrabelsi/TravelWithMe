<?php

namespace App\Form;

use App\Entity\TransportReservation;
use App\Entity\User;
use App\Entity\MoyTransport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\EntityManagerInterface;

class TransportReservationType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reservation_datetime', DateType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('passenger_count', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Type('integer'),
                ],
            ])
            ->add('customer', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id_customer',
                'constraints' => [
                    new NotBlank(),
                    new Callback([$this, 'validateCustomer']),
                ],
            ])
            ->add('transport', EntityType::class, [
                'class' => MoyTransport::class,
                'choice_label' => 'id_transport',
                'constraints' => [
                    new NotBlank(),
                    new Callback([$this, 'validateTransport']),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TransportReservation::class,
        ]);
    }

    public function validateCustomer($value, ExecutionContextInterface $context)
    {
        $user = $this->entityManager->getRepository(User::class)->find($value);

        if (!$user) {
            $context->buildViolation('Invalid customer selected.')
                ->atPath('customer')
                ->addViolation();
        }
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