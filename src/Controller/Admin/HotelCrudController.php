<?php

namespace App\Controller\Admin;

use App\Entity\Hotel;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HotelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Hotel::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Hotel')
            ->setEntityLabelInPlural('Hotels');
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
