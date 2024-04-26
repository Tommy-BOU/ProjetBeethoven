<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\EditProfileType;
use App\Repository\UserRepository;
use App\Repository\BorrowingRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubscriptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'app_profile_show', methods: ['GET','SET'])]
    public function show(BorrowingRepository $borrowingRepository, SubscriptionRepository $subscriptionRepository): Response
    {
        $user = $this->getUser();
        $borrowings = $borrowingRepository->findByUser($user->getId());
        $historyborrowings = $borrowingRepository->findReturnedByUser($user->getId());
        $subscriptions = $subscriptionRepository->findOneBy(['user' => $user]);
        return $this->render('profile/show.html.twig', [
            'user' => $user,
            'borrowings' => $borrowings,
            'historyborrowings' => $historyborrowings,
            'subscriptions' => $subscriptions

        ]);
    }

    #[Route('/edit', name: 'app_profile_edit', methods: ['GET'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Votre profil a bien été mis à jour');
            return $this->redirectToRoute('app_profile_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
   
}

