<?php

namespace App\Form;

use App\Entity\Groupe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Import EntityType
use App\Entity\Voyage;
use App\Entity\User;

class Groupe1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('utilisateur', EntityType::class, [
            'class' => User::class,
            'choice_label' => 'id', // Choose the property to display as the option label
        ])
            ->add('voyage', EntityType::class, [ // Add EntityType field for selecting Voyage
                'class' => Voyage::class,
                'choice_label' => 'id', // Change this to the property of Voyage you want to display in the dropdown
                'placeholder' => 'Select a Voyage', // Optional placeholder text
            ])
            ->add('number_membre')	
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Groupe::class,
        ]);
    }
}
