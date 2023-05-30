<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['attr'=> ['class' => 'form-control']])
            ->add('description', TextType::class, ['attr'=> ['class' => 'form-control']])
            ->add('poster')
            ->add('nb_max_pers', IntegerType::class, ['attr'=> ['class' => 'form-control']])
            ->add('date_create', DateType::class, [
                'widget' => 'single_text',
                'attr'=> ['class' => 'form-control']])
            ->add('user')
            ->add('participates')
            ->add('multimedias')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
