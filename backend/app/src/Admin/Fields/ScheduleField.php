<?php

namespace App\Admin\Field;

use App\Form\ScheduleType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

final class ScheduleField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setTemplatePath('admin/field/map.html.twig')
            ->setFormType(ScheduleType::class)
        ;
    }
}