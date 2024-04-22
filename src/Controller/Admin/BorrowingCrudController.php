<?php

namespace App\Controller\Admin;

use App\Entity\Borrowing;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BorrowingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Borrowing::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'Borrowing Id');
        yield AssociationField::new('user');
        yield AssociationField::new('book', 'Book Id')->formatValue(function ($value) {
            return $value->getId();
        });
        yield AssociationField::new('book', 'Book title');

        yield BooleanField::new('prolongated')->renderAsSwitch(false);

        yield DateTimeField::new('borrowingDate')
            ->formatValue(function ($value) {
                return $value->format('Y-m-d');
            });

        // $currentDate = new \DateTime();

        // $cssClass = DateTimeField::new('expectedReturnDate')->formatValue(function ($value) {
        //     dd($value);
        //     return $value;
        // }) < $currentDate ? 'text-danger' : '';

        yield DateTimeField::new('expectedReturnDate')->formatValue(function ($value) {
            return $value->format('Y-m-d');
        });

       yield DateTimeField::new('finalReturnDate')->formatValue(function ($value) {
            if ($value === null) {
                return null;
            } else {
                return $value->format('Y-m-d');
            }
        });

        // $fieldsArray = [
        //     $id,
        //     $bookId,
        //     $bookImg,
        //     $book,
        //     $prolongated,
        //     $borrowingDate,
        //     $expectedReturnDate,
        //     $finalReturnDate
        // ];

        // return $fieldsArray;
    }

    public function configureActions(Actions $actions): Actions
    {
        $confirmReturn = Action::new('confirmReturn', 'Confirm return')
            ->displayAsLink()
            // renders the action as a <button> HTML element
            ->displayAsButton()
            ->linkToCrudAction('returnBook');

        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, $confirmReturn)
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }

    public function returnBook()
    {

        dd('test');
    }
}
