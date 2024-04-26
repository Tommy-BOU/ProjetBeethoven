<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\State;
use Doctrine\ORM\EntityManager;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BookCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Livre')
            ->setEntityLabelInPlural('Livres')
            ->setSearchFields(['id', 'title', 'author', 'state.name', 'publicationYear', 'globalRating', 'available'])
            ->setDefaultSort(['id' => 'ASC']);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->hideOnForm(),
            TextField::new('author','Auteur'),
            IntegerField::new('publicationYear', 'Année de publication'),
            TextField::new('title', 'Titre'),
            TextField::new('image', 'Image'),
            AssociationField::new('state', 'État'),
            BooleanField::new('available', 'Disponible')->renderAsSwitch(false),
            NumberField::new('globalRating', 'Note globale'),

        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::EDIT);
    }
}
