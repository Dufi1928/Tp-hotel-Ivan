<?php

namespace App\Controller\Admin;

use App\Entity\Suite;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Doctrine\ORM\QueryBuilder;

class SuiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Suite::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Suite')
            ->setEntityLabelInPlural('Suites');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextEditorField::new('description'),
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

    public function configureEntity(EntityDto $entityDto, Crud $crud, EntityManagerInterface $entityManager): void
    {
        $suiteQueryBuilder = $entityManager->createQueryBuilder()
            ->select('s')
            ->from(Suite::class, 's')
            ->join('s.hotel', 'h');

        $crud->setEntityQueryBuilder($suiteQueryBuilder);
    }
}
