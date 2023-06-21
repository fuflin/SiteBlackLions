<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Multimedia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MultimediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('media', FileType::class,  [
                'attr'=>
                [
                    'class' => 'form-control',
                    'placeholder' => "format accepter: .jpeg, .png, .jpg, .mp4"
                ],

                'label' => 'Media à enregistrer',
                'multiple' => true, // paramètre permettant à l'utilisateur de pouvoir ajouter plusieurs fichiers en même temps
                'mapped' => false,
                'required' => false,
                'constraints' =>
                [
                    new All
                    ([
                        'constraints' =>
                        [
                            new File([
                                'maxSize' => '1024M',
                                'mimeTypes' =>
                                [
                                    'image/jpeg',
                                    'image/png',
                                    'image/jpg',
                                    'video/mp4'
                                ]
                            ])
                        ]
                    ])
                ]
            ])

            ->add('event', EntityType::class, [
                'class' => Event::class
            ])

            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Multimedia::class,
        ]);
    }
}
