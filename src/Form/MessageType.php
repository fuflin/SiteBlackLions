<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('title', TextType::class, ['attr'=> [
                'class' => 'form-control',
                'placeholder' => "Titre du message"],
                'label' => 'Titre'])

            ->add('text', TextareaType::class, [
                'attr'=> [
                'class' => 'form-control',
                'placeholder' => "Saisissez votre message"],
                'label' => 'Contenu du message'])

            ->add('received', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                // 'label' => 'Destinataires',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])

            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}