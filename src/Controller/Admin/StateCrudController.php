<?php

namespace App\Controller\Admin;

use App\Entity\State;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return State::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
            AssociationField::new('books')->setFormTypeOption('choice_label', 'name')
                ->setFormTypeOption('by_reference', false),
        ];
    }
}
