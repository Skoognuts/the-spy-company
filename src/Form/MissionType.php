<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Contact;
use App\Entity\Target;
use App\Entity\Hideout;
use App\Entity\Mission;
use App\Entity\Specialty;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['required' => true])
            ->add('description', TextareaType::class, ['required' => true])
            ->add('country', TextType::class, ['required' => true])
            ->add('startDate', BirthdayType::class, ['required' => true])
            ->add('endDate', BirthdayType::class, ['required' => true])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'En préparation' => 'En préparation',
                    'En cours' => 'En cours',
                    'Terminé' => 'Terminé',
                    'Echec' => 'Echec'
                ],
                'multiple' => false,
                'required' => true
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Assassinat' => 'Assassinat',
                    'Assistance' => 'Assistance',
                    'Contre Espionnage' => 'Contre Espionnage',
                    'Espionnage' => 'Espionnage',
                    'Infiltration' => 'Infiltration',
                    'Surveillance' => 'Surveillance'
                ],
                'multiple' => false,
                'required' => true
            ])
            ->add('agents', EntityType::class, [
                'class' => Agent::class,
                'multiple' => true,
                'required' => true
            ])
            ->add('contacts', EntityType::class, [
                'class' => Contact::class,
                'multiple' => true,
                'required' => true
            ])
            ->add('targets', EntityType::class, [
                'class' => Target::class,
                'multiple' => true,
                'required' => true
            ])
            ->add('hideouts', EntityType::class, [
                'class' => Hideout::class,
                'multiple' => true,
                'required' => false
            ])
            ->add('requiredSpecialty', EntityType::class, [
                'class' => Specialty::class,
                'multiple' => false,
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
