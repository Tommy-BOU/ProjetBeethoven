<?php

namespace App\Controller\Admin;

use App\Entity\Borrowing;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BorrowingCrudController extends AbstractCrudController
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
    public static function getEntityFqcn(): string
    {
        return Borrowing::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Emprunt')
            ->setEntityLabelInPlural('Emprunts')
            ->setSearchFields(['id', 'book.title', 'user.LastName', 'user.FirstName', 'prolongated', 'borrowingDate', 'expectedReturnDate', 'finalReturnDate'])
            ->setDefaultSort(['borrowingDate' => 'DESC'])
            ->hideNullValues();
    }


    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('id')->hideOnForm();
        yield AssociationField::new('user', 'Utilisateur');
        yield AssociationField::new('book', 'Titre du livre');
        yield AssociationField::new('book', 'ID du livre')->formatValue(function ($value) {
            return $value->getId();
        });

        yield BooleanField::new('prolongated', 'Prolongé')->renderAsSwitch(false);

        yield DateTimeField::new('borrowingDate', 'Date d\'emprunt')
            ->formatValue(function ($value) {
                return $value->format('d-m-Y');
            });

        yield DateTimeField::new('expectedReturnDate', 'Date de retour prévu')->formatValue(function ($value) {
            return $value->format('d-m-Y');
        })
            ->setTemplatePath('admin/field/date_expected_return.html.twig');


        yield DateTimeField::new('finalReturnDate', 'Date de retour finale')->formatValue(function ($value) {
            if ($value === null) {
                return null;
            } else {
                return $value->format('d-m-Y');
            }
        });
    }

    public function configureActions(Actions $actions): Actions
    {
        $confirmReturn = Action::new('confirmReturn', 'Confirmer retour')
            ->setCssClass('text-success')
            ->linkToCrudAction('returnBook')
            ->setHtmlAttributes([
                'onclick' => 'return confirm("Êtes vous sûr de vouloir confimer ce retour?");'
            ]);

        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, $confirmReturn)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE)
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }

    public function returnBook(AdminContext $context, AdminUrlGenerator $adminUrlGenerator)
    {

        $borrowing = $context->getEntity()->getInstance();

        $em = $this->entityManager;

        if ($borrowing->getFinalReturnDate() == null) 
        {
            $borrowing->setFinalReturnDate(new \DateTime());

            $book = $borrowing->getBook();
            $book->setAvailable(true);

            $em->persist($borrowing);
            $em->persist($book);

            $em->flush();
        }

        $targetUrl = $adminUrlGenerator
            ->setController(self::class)
            ->setAction(Crud::PAGE_INDEX)
            ->generateUrl();

        return $this->redirect($targetUrl);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('user')
            ->add('book')
            ->add('prolongated')
            ->add('borrowingDate')
            ->add('expectedReturnDate')
            ->add('finalReturnDate');
    }
}
