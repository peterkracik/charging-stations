<?php

namespace App\Form;

use App\Entity\Schedule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('openMonday', null, [
                'data' => true,
            ])
            ->add('monday', null, [
                 'help' => 'To override store opening hours',
            ])
            ->add('openTuesday', null, [
                'data' => true,
            ])
            ->add('tuesday', null, [
                 'help' => 'To override store opening hours',
            ])
            ->add('openWednesday', null, [
                'data' => true,
            ])
            ->add('wednesday', null, [
                 'help' => 'To override store opening hours',
            ])
            ->add('openThursday', null, [
                'data' => true,
            ])
            ->add('thursday', null, [
                 'help' => 'To override store opening hours',
            ])
            ->add('openFriday', null, [
                'data' => true,
            ])
            ->add('friday', null, [
                 'help' => 'To override store opening hours',
            ])
            ->add('openSaturday', null, [
                'data' => true,
            ])
            ->add('saturday', null, [
                 'help' => 'To override store opening hours',
            ])
            ->add('openSunday', null, [
                'data' => true,
            ])
            ->add('sunday', null, [
                 'help' => 'To override store opening hours',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Schedule::class,
        ]);
    }
}
