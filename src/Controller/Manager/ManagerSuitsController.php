<?php

namespace App\Controller\Manager;

use App\Entity\Suite;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ManagerSuitsController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Suite::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextEditorField::new('description'),
            NumberField::new('hotel.id'),
            MoneyField::new('price')->setCurrency('USD'),
            ImageField::new('image_name')
                ->setBasePath('/uploads/img/rooms')
                ->setUploadDir('public/uploads/img/rooms')
                ->setRequired(false)
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setFormTypeOption('mapped', true)
                ->setLabel('Photo')
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $manager = $this->getUser();

        if ($manager->getHotel() !== null) {
            $queryBuilder
                ->andWhere('entity.hotel = :hotel_id')
                ->setParameter('hotel_id', $manager->getHotel()->getId());
        }

        return $queryBuilder;
    }
}
