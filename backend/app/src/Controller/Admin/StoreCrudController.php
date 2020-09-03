<?php

namespace App\Controller\Admin;

use App\Admin\Fields\ScheduleField as FieldsScheduleField;
use App\Entity\Store;
use App\Form\StoreScheduleExceptionType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

class StoreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Store::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('General'),
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            AssociationField::new('tenant'),
            FormField::addPanel('Opening hours'),
            FieldsScheduleField::new('schedule')
                ->onlyOnForms(),
            FormField::addPanel('Exceptions'),
            CollectionField::new('scheduleExceptions')
            ->allowAdd()
                ->allowDelete()
                ->setEntryIsComplex(true)
                ->setEntryType(StoreScheduleExceptionType::class)
                ->setFormTypeOptions([
                    'by_reference' => false
                ]),
        ];
    }
}
