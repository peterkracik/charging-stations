<?php

namespace App\Form;

use App\Entity\StationScheduleException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StationScheduleExceptionType extends ScheduleExceptionType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StationScheduleException::class,
        ]);
    }
}
