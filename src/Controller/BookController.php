<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    public function __construct(private BookRepository $bookRepository)
    {
    }
    #[Route('/book', name: 'app_book')]
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $books = $this->bookRepository->findWithState($page);
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
            'books' => $books,
        ]);
    }

    #[Route('/details/{id}', name: 'app_details')]
    public function details(int $id): Response
    {
        $book = $this->bookRepository->findwithState(0,$id);
        return $this->render('book/details.html.twig', [
            'controller_name' => 'BookController',
            'book' => $book
        ]);
    }
}
