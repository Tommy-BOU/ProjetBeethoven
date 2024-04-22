<?php

namespace App\Controller;

use App\Entity\Borrowing;
use App\Repository\BookRepository;
use App\Repository\BorrowingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BorrowingController extends AbstractController
{
    public function __construct(private BookRepository $bookRepository, private EntityManagerInterface $entityManager, private BorrowingRepository $borrowingRepository)
    {

    }

    #[Route('/profile/borrow/{id}', name: 'app_borrow')]
    public function borrow(int $id): Response
    {
        $borrowing = new Borrowing();
        $book = $this->bookRepository->findwithState(0, $id);

        if (!$book) {
            throw $this->createNotFoundException('No book found for id ' . $id);
        }

        $user = $this->getUser();

        if ($user && $book->isAvailable())
        {
            $book->setAvailable(false);
            $borrowing->setBorrowingDate(new \DateTimeImmutable());
            $borrowing->setExpectedReturnDate((new \DateTimeImmutable())->add(new \DateInterval('P6D')));
            $borrowing->setUser($user);
            $borrowing->setBook($book);
            $borrowing->setProlongated(false);
    
            $this->entityManager->persist($borrowing);
            $this->entityManager->flush();
            return $this->render('borrowing/borrow.html.twig', [
                'book' => $book,
                'borrowing' => $borrowing
            ]);
        }
        else{
            return $this->render('borrowing/error.html.twig');
        }

    }

    #[Route('/profile/extend/{id}', name: 'app_extend')]
    public function extendBorrow(int $id): Response
    {
        $borrowing = $this->borrowingRepository->findOneBy(['id' => $id]);
        $user = $this->getUser();
        // Ignore this error. getId does exist
        if ($user->getId() == $borrowing->getUser()->getId() && $borrowing->isProlongated() == false)
        {
            $newExpectedReturnDate = new \DateTime($borrowing->getExpectedReturnDate()->format('Y-m-d H:i:s'));
            $newExpectedReturnDate->modify('+6 days');
            $borrowing->setExpectedReturnDate($newExpectedReturnDate);
            $borrowing->setProlongated(true);
            $this->entityManager->flush();
            return $this->render('borrowing/extend.html.twig', [
                'borrowing' => $borrowing
            ]);
        }
        else{
            return $this->render('borrowing/error.html.twig');
        }

    }
}
