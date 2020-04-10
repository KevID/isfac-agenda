<?php

namespace App\Form;

use App\Entity\Agenda;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgendaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description', null, [
                'attr' => ['rows' => 10],
            ])
            ->add('dateHeure', DateTimeType::class, [
                'html5' => true,
                'widget' => 'single_text',
                'with_seconds' => false,
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Agenda::class,
        ]);
    }
}
