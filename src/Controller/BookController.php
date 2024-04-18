<?php

namespace App\Controller;

use App\DTO\SearchData;
use App\Form\SearchType;
use App\Repository\BookRepository;
use App\Repository\BorrowingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    public function __construct(private BookRepository $bookRepository, private BorrowingRepository $borrowingRepository, private EntityManagerInterface $entityManager)
    {
    }
    #[Route('/book', name: 'app_book')]
    public function index(Request $request, SearchData $searchData): Response
    {

        $page = $request->query->getInt('page', 1);
        $searchData->page = $page;
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        $params = [
            "query" => $searchData->query,
            "page" => $page
        ];

        if ($form->isSubmitted() && $form->isValid()) {
            $searchBook = $this->bookRepository->searchResult();
            $totalBook = $this->bookRepository->searchResultNoPaginate();
            $borrowings = $this->borrowingRepository->findNonReturned();
            return $this->render('book/index.html.twig', [
                'total' => $totalBook,
                'res' => $searchBook,
                'formView' => $form->createView(),
                'params' => $params,
                'borrowings' => $borrowings
            ]);
        }
        else{
            $books = $this->bookRepository->findWithState($page);
            $borrowings = $this->borrowingRepository->findNonReturned();
            return $this->render('book/index.html.twig', [
                'books' => $books,
                'formView' => $form->createView(),
                'borrowings' => $borrowings
            ]);
        }


    }

    #[Route('/details/{id}', name: 'app_details')]
    public function details(int $id): Response
    {
        $book = $this->bookRepository->findwithState(0, $id);
        $borrowing = $this->borrowingRepository->findOneBy(['book' => $id]);
        return $this->render('book/details.html.twig', [
            'book' => $book,
            'borrowing' => $borrowing
        ]);
    }
}
