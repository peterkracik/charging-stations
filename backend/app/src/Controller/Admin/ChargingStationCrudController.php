<?php

namespace App\Controller\Admin;

use App\Admin\Fields\ScheduleField;
use App\Entity\ChargingStation;
use App\Form\StationScheduleExceptionType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class ChargingStationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ChargingStation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('General'),
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            AssociationField::new('store'),
            FormField::addPanel('Opening hours'),
            ScheduleField::new('schedule')
                ->onlyOnForms(),
            FormField::addPanel('Exceptions'),
            CollectionField::new('scheduleExceptions')
                ->allowAdd()
                ->allowDelete()
                ->setEntryIsComplex(true)
                ->setEntryType(StationScheduleExceptionType::class)
                ->setFormTypeOptions([
                    'by_reference' => false
                ])
                ->onlyOnForms(),
        ];
    }
}
