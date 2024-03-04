<?php

// src/Form/VoyageType.php

namespace App\Form;

use App\Entity\Voyage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class VoyageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vehicule', EntityType::class, [
                'class' => 'App\Entity\MoyTransport',
                'choice_label' => 'id_transport', // Choose the property to display as the option label
            ])
            ->add('accomodation', EntityType::class, [
                'class' => 'App\Entity\Accomodation',
                'choice_label' => 'id', // Choose the property to display as the option label
            ])
            ->add('evenement', EntityType::class, [
                'class' => 'App\Entity\Event',
                'choice_label' => 'id', // Choose the property to display as the option label
            ])
            ->add('utilisateur', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id', // Choose the property to display as the option label
            ])
            ->add('depart', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('arrivee', DateType::class, [
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voyage::class,
        ]);
    }
}
