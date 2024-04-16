<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    public function __construct(private BookRepository $bookRepository)
    {
    }
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        $books = $this->bookRepository->findAll();
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
            'books' => $books
        ]);
    }

    #[Route('/details/{id}', name: 'app_details')]
    public function details(int $id): Response
    {
        $book = $this->bookRepository->findwithState($id);
        return $this->render('book/details.html.twig', [
            'controller_name' => 'BookController',
            'book' => $book
        ]);
    }
}
