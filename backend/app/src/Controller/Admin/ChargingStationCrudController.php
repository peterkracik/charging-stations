<?php

namespace App\Controller\Admin;

use App\Entity\ChargingStation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ChargingStationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ChargingStation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            AssociationField::new('store'),
        ];
    }
}
