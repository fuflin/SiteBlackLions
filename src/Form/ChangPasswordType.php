<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

use Symfony\Component\Validator\Constraints as Assert;

class ChangPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('plainPassword', PasswordType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Ancien mot de passe',
                // 'first_options' => [
                //     'constraints' => [
                //         new NotBlank([
                //             'message' => 'Please enter a password',
                //         ]),
                //     ]
                // ],
            ])

            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ],
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a password',
                        ]),
                        new Length([
                            'min' => 1,
                            'minMessage' => 'Your password should be at least {{ limit }} characters',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'label' => 'New password',
                ],
                'second_options' => [
                    'label' => 'Repeat Password',
                ],
                'invalid_message' => 'The password fields must match.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])

            // ->add('plainPassword', RepeatedType::class, [
            //     // instead of being set onto the object directly,
            //     // this is read and encoded in the controller
            //     'mapped' => false,
            //     'type' => PasswordType::class,
            //     'attr' => ['autocomplete' => 'new-password'],
            //     'options' => ['attr' => ['class' => 'password-field']],
            //         'required' => true,
            //         'attr'=> [
            //             'class' => 'form-control',
            //             ],
            //         'first_options' => ['label' => 'Mot de passe', 'attr' =>['placeholder' => '12 characters min']],
            //         'second_options' => ['label' => 'Confirmer le mot de passe', 'attr' =>['placeholder' => '12 characters min']],
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Entrez un mot de passe',
            //         ]),
            //         // new Regex([ //la regex impose des conditions pour le mdp: 1 majuscule, 1 minuscule, 1 nombre, 1 charactère spéciale
            //         //     'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,32}$',
            //         //     'match' => true,
            //         //     'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un nombre, un caractère spéciale compris entre 12 et 32 caractères'
            //         //     ]),
            //         ],
            //     ])

            //     ->add('newPassword', PasswordType::class, [
            //         'attr' => ['class' => 'form-control'],
            //         'label' => 'Nouveau mot de passe',
            //         'label_attr' => ['class' => 'form-label mt-4'],
            //         // 'constrains' => [new Assert\NotBlank()]
            //     ])

            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
