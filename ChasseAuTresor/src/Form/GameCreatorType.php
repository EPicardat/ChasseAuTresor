<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Entity\Parties;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameCreatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('date_debut',  TextType::class , array('required' => false))
            ->add('date_fin',TextType::class, array('required' => false))
            ->add('privee', TextType::class, array('required' => false))
            ->add('photo')
            ->add('latitude')
            ->add('longitude')
            ->add('message_fin')
            ->add('accuracy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Parties::class,
        ]);
    }
}
