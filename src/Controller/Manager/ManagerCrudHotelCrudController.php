<?php

namespace App\Controller\Manager;

use App\Entity\Hotel;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;

class ManagerCrudHotelCrudController extends AbstractCrudController
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

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $manager = $this->getUser();

        if ($manager->getHotel() !== null) {
            $queryBuilder
                ->andWhere('entity.id = :hotel_id')
                ->setParameter('hotel_id', $manager->getHotel()->getId());
        } else {
            // If the manager does not have an associated hotel, display no hotels
            $queryBuilder
                ->andWhere('1 = 0');
        }

        return $queryBuilder;
    }

}
