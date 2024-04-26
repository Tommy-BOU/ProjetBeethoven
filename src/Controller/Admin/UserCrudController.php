<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setSearchFields(['id', 'Email', 'LastName', 'FirstName', 'Birthdate', 'Address', 'City', 'zipCode', 'telephone', 'roles'])
            ->setDefaultSort(['id' => 'ASC']);
            
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->hideOnForm(),
            EmailField::new('Email'),
            TextField::new('LastName', 'Nom'),
            TextField::new('FirstName', 'Prénom'),
            DateField::new('Birthdate', 'Date de naissance'),
            TextField::new('Address', 'Adresse'),
            TextField::new('City', 'Ville'),
            IntegerField::new('zipCode', 'Code Postal'),
            IntegerField::new('telephone'),
            ArrayField::new('roles'),

        ];
    }
    
}
