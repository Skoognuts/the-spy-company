<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Specialty;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, ['required' => true])
            ->add('firstName', TextType::class, ['required' => true])
            ->add('dateOfBirth', BirthdayType::class, ['required' => true])
            ->add('nationality', TextType::class, ['required' => true])
            ->add('specialties', EntityType::class, [
                'class' => Specialty::class,
                'multiple' => true,
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agent::class,
        ]);
    }
}
