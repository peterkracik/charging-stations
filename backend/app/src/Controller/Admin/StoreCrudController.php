<?php

namespace App\Controller\Admin;

use App\Admin\Field\ScheduleField;
use App\Entity\Store;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
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
            ScheduleField::new('schedule')
                ->onlyOnForms(),
        ];
    }
}
