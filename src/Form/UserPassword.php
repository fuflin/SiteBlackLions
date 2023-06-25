<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Nouveau mot de passe',
                    'attr' => [
                        'class' => 'form-control'
                        ]],
                'second_options' => [
                    'label' => 'Confirmation mot de passe',
                    'attr' => [
                        'class' => 'form-control'
                        ]],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                    ]),
                    // new Regex([ //la regex impose des conditions pour le mdp: 1 majuscule, 1 minuscule, 1 nombre, 1 charactère spéciale
                    //     'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.$!%*?&])[A-Za-z\d@.$!%*?&]{12,32}$/',
                    //     'match' => true,
                    //     'message' => 'Le mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 nombre, 1 caractère spéciale compris entre 12 et 32 caractères'
                    //     ]),
                ],
                'invalid_message' =>'les motes de passe ne correspondent pas.'
            ])

            ->add('plainPassword', PasswordType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Ancien mot de passe',
                'label_attr' => ['class' => 'form-label mt-4'],
            ])

            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
