<?php

// src/Form/AjoutFrontType.php

namespace App\Form;

use App\Entity\Voyage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AjoutFrontType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('vehicule', EntityType::class, [
            'class' => 'App\Entity\MoyTransport',
            'choice_label' => 'transport_model'
        ])
        ->add('accomodation', EntityType::class, [
            'class' => 'App\Entity\Accomodation',
            'choice_label' => 'Lieu',
        ])
        ->add('evenement', EntityType::class, [
            'class' => 'App\Entity\Event',
            'choice_label' => 'nom',
        ])
        ->add('depart', DateType::class, [
            'widget' => 'single_text',
        ])
        ->add('arrivee', DateType::class, [
            'widget' => 'single_text',
        ])
        ->add('utilisateur', EntityType::class, [
            'class' => 'App\Entity\User',
            'choice_label' => 'email'
        ]);
        
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voyage::class,
        ]);
    }
}
