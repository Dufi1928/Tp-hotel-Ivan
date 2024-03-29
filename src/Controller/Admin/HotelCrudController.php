<?php
namespace App\Controller\Admin;

use App\Entity\Hotel;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HotelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Hotel::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Name'),
            TextareaField::new('description', 'Description'),
            TextField::new('address', 'Address'),
            TextField::new('city', 'City'),
            EmailField::new('email', 'Email'),
            ImageField::new('coverImgName')
                ->setBasePath('/uploads/img/hotels')
                ->setUploadDir('public/uploads/img/hotels')
                ->setRequired(false)
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setFormTypeOption('mapped', true)
                ->setLabel('Covet Image')
        ];
    }
}

