<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickname', TextType::class, ['attr'=> [
                'class' => 'form-control',
                'placeholder' => 'Entrez votre pseudo'
            ]])

            ->add('email', EmailType::class, ['attr'=> [
                'class' => 'form-control',
                'placeholder' => 'Entrez une adresse email'
            ]])


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
                    'first_options' => ['label' => 'Mot de passe', 'attr' =>['placeholder' => '12 characters min']],
                    'second_options' => ['label' => 'Repéter le mot de passe', 'attr' =>['placeholder' => '12 characters min']],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                    ]),
                    // new Regex([ //la regex impose des conditions pour le mdp: 1 majuscule, 1 minuscule, 1 nombre, 1 charactère spéciale
                    //     'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,32}$',
                    //     'match' => true,
                    //     'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un nombre, un caractère spéciale compris entre 12 et 32 caractères'
                    //     ]),
                    ],
                ])
                ->add('discord_nickname', TextType::class, [
                    'attr'=> [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre pseudo discord'
                    ],
                    'required' => false
                ])

                ->add('submit', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-primary']])

                ->add('agreeTerms', CheckboxType::class, [
                    'mapped' => false,
                    'constraints' => [
                        new IsTrue([
                            'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
