<?php

namespace App\Controller\Admin;

use App\Admin\Field\ScheduleField;
use App\Entity\Tenant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
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
            TextField::new('name')
        ];
    }
}
