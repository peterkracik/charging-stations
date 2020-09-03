<?php

namespace App\Controller\Admin;

use App\Entity\Tenant;
use App\Form\TenantScheduleExceptionType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

class TenantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tenant::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Basic information'),
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            FormField::addPanel('Exceptions'),
            CollectionField::new('scheduleExceptions')
            ->allowAdd()
                ->allowDelete()
                ->setEntryIsComplex(true)
                ->setEntryType(TenantScheduleExceptionType::class)
                ->setFormTypeOptions([
                    'by_reference' => false
                ])
                ->onlyOnForms(),
        ];
    }
}
