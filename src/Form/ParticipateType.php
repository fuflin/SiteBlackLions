<?php

namespace App\Form;

use App\Entity\Participate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ParticipateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('date_regis')
            // ->add('events')
            // ->add('users')

            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participate::class,
        ]);
    }
}
