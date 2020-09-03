<?php

namespace App\Form;

use App\Entity\StoreScheduleException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreScheduleExceptionType extends ScheduleExceptionType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StoreScheduleException::class,
        ]);
    }
}
