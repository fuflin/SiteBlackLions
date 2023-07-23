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
            // ici le champ du formalaire est restraint à du texte
            ->add('nickname', TextType::class, ['attr'=> [
                'class' => 'form-control',
                'placeholder' => 'Entrez votre pseudo'],
                'label' => 'Pseudo'
            ])
            // ici si une adresse mail n'est pas saisie le champ ne sera pas validé
            ->add('email', EmailType::class, ['attr'=> [
                'class' => 'form-control',
                'placeholder' => 'Entrez une adresse email'],
                'label' => 'Adresse email'
            ])


            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'attr' => ['autocomplete' => 'new-password'],
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'attr'=> ['class' => 'form-control',],
                'first_options' => ['attr' =>['placeholder' => '12 characters min'],
                    'label' => 'Mot de passe'],
                'second_options' => ['attr' =>['placeholder' => '12 characters min'],
                    'label' => 'Repéter le mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                        ]),
                    new Regex([
                        'pattern' => '/^(?=.*\d)(?=.*[!-\/:-@[-`{-~À-ÿ§µ²°£])(?=.*[a-z])(?=.*[A-Z])(?=.*[A-Za-z]).{12,32}$/',
                        'match' => true,
                        'message' => 'Le mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 nombre, 1 caractère spéciale et doit faire au moins 12 caractères.',
                        ]),
                    ],
                ])

                ->add('discord_nickname', TextType::class, [
                    'attr'=> [
                    'class' => 'form-control',
                    'label' => 'Pseudo Discord',
                    'placeholder' => 'Entrez votre pseudo discord'
                    ],
                    'required' => false
                ])

                ->add('submit', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-primary']])

                ->add('agreeTerms', CheckboxType::class, [
                    'mapped' => false,
                    'label' => "Conditions d'utilisation",
                    'constraints' => [
                        new IsTrue([
                            'message' => 'Veuillez acceptez les conditions.',
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
