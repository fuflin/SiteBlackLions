<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['attr'=> [
                'class' => 'form-control',
                'placeholder' => "Nom de l'événement"],
                'label' => 'Nom'])

            ->add('description', TextType::class, ['attr'=> [
                'class' => 'form-control',
                'placeholder' => "Saisissez la description"],
                'label' => 'Description'])

            ->add('poster', FileType::class, [
                'attr'=> [
                    'class' => 'form-control',
                    'placeholder' => "url de l'image"],
                'label' => 'Affiche événement',
                'mapped' => false,
                'required' => false,
                'constraints' =>[
                    new File([
                        'maxSize' => '10M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg'
                        ]
                    ])
                ]])

            ->add('nb_max_pers', IntegerType::class, ['attr'=> [
                'class' => 'form-control',
                'placeholder' => "Nombre de personnes"],
                'label' => 'Nombre de participants'])

            ->add('date_create', DateType::class, [
                'widget' => 'single_text',
                'attr'=> ['class' => 'form-control']])

            // ->add('user')
            // ->add('participates')
            // ->add('multimedias')

        ->add('submit', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
