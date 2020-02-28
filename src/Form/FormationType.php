<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', ChoiceType::class, ['label' => 'Le stage est proposé aux formations suivantes:', 'choices' => ['DUT Informatique' => 'dutinfo', 'Licence Professionnalle Systèmes Informatiques et Logiciels, option Communication Multimédia' => 'lpsil', 'Diplôme Universitaire en Technologies de l\'Information et de la Communication' => 'duttic'], 'expanded' => true, 'multiple' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
