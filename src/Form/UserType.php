<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['attr'=> [
                'class' => 'form-control',
                'placeholder' => 'Entrez une adresse email'
            ]])

            ->add('roles')

            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'type' => PasswordType::class,
                'attr' => ['autocomplete' => 'new-password'],
                'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'attr'=> [
                        'class' => 'form-control',
                        ],
                    'first_options' => ['label' => 'Password', 'attr' =>['placeholder' => '12 characters min']],
                    'second_options' => ['label' => 'Repeat Password', 'attr' =>['placeholder' => '12 characters min']],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    // new Regex([ //la regex impose des conditions pour le mdp: 1 majuscule, 1 minuscule, 1 nombre, 1 charactère spéciale
                    //     'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,32}$',
                    //     'match' => true,
                    //     'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un nombre, un caractère spéciale compris entre 12 et 32 caractères'
                    //     ]),
                    ],
                ])

            ->add('nickname', TextType::class, ['attr'=> [
                'class' => 'form-control',
                'placeholder' => 'Entrez votre pseudo'
            ]])

            ->add('date_create')

            ->add('discord_nickname', TextType::class, [
                'attr'=> [
                'class' => 'form-control',
                'placeholder' => 'Entrez votre pseudo discord'
                ],
                'required' => false
            ])

            ->add('isVerified')

            ->add('is_banned', CheckboxType::class, [
                'label' => 'Banni',
                'required' => false,
                'switch_widget' => true,
            ])

            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary']]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
