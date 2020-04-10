<?php

namespace App\Form;

use App\Entity\ChangePassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'label' => 'Ancien mot de passe',
            ])
            ->add('Password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' => 'Répéter le nouveau mot de passe'],
                'invalid_message' => 'Les deux mots de passe doivent être identiques',
                'options' => [
                    'attr' => [
                        'class' => 'password-field',
                    ],
                ],
                'required' => true,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //mettre le nouveau formulaire
            'data_class' => ChangePassword::class,
            'csrf_token_id' => 'change_password',
        ]);
    }
}
