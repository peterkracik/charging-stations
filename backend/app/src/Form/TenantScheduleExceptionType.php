<?php

namespace App\Form;

use App\Entity\TenantScheduleException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TenantScheduleExceptionType extends ScheduleExceptionType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TenantScheduleException::class,
        ]);
    }
}
