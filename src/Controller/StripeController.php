<?php

namespace App\Controller;

use Stripe\Stripe;

use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{

    #[Route('/create-session-stripe/{type}', name: 'subscription_stripe')]
    public function subscription($type, UrlGeneratorInterface $generator): RedirectResponse
    {
        $key = "sk_test_51P7JiyCqnN6c9mhAdJbCxaT5O6f8UgzA2Klca1JvbnMqCL1jkpSddiEqujJ4mKdre7k62xrYBcvQi26FcN8v0JfQ00nnYezIY8";
        Stripe::setApiKey($key);
        $order = [];

        if ($type == 'monthly') {
            $order['name'] = 'Abonnement mensuel';
            $order['price'] = 23.99;
        }

        if ($type == 'yearly') {
            $order['name'] = 'Abonnement annuel';
            $order['price'] = 259.10;
        }

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[

                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $order['price'] * 100,
                    'product_data' => [
                        'name' => $order['name'],
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $generator->generate('app_subscription_process', ['type' => $type], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $generator->generate('app_profile_show', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        return $this->redirect($checkout_session->url);
    }
    #[Route('/process/{type}', name: 'app_subscription_process')]
    public function process(string $type, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
       

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non connecté');
        }

        if ($type == 'monthly') {
            $monthlySubscription = new Subscription();
            $monthlySubscription->setCurrentPeriodStart(new \DateTime());
            $monthlySubscription->setCurrentPeriodEnd(new \DateTime('+1 month'));
            $monthlySubscription->setUser($user);
            $monthlySubscription->setIsActive(true);
            $manager->persist($monthlySubscription);

            $this->addFlash('success', 'Votre abonnement a bien été mis à jour');
        }

        if ($type == 'yearly') {
            $yearlySubscription = new Subscription();
            $yearlySubscription->setCurrentPeriodStart(new \DateTime());
            $yearlySubscription->setCurrentPeriodEnd(new \DateTime('+1 year'));
            $yearlySubscription->setUser($user);
            $yearlySubscription->setIsActive(true);
            $manager->persist($yearlySubscription);

            $this->addFlash('success', 'Votre abonnement a bien été mis à jour');
        }

        $manager->flush();

        return $this->redirectToRoute('app_profile_show');
    }





    // route à creer qui recupère le type d'abonnement dans l'url puis creer dans repo le type d'abonnement
}



    // #[Route('/payment-information', name: 'payment_information', methods: ['POST'])]
    // public function paymentInformation(Request $request): Response
    // {

    //     $subscriptionType = $request->request->get('abonnement');
    //     $amount = $subscriptionType === 'annuel' ? 25908 : 2399; 


    //     $session = $request->getSession();
    //     $session->set('subscription_type', $subscriptionType);
    //     $session->set('amount', $amount);


    //     return $this->render('stripe/payment-information.html.twig', [
    //         'stripe_key' => $_ENV["STRIPE_KEY"],
    //         'amount' => $amount / 100, 
    //         'subscriptionType' => $subscriptionType
    //     ]);
    // }
    //     #[Route('/stripe', name: 'app_stripe')]
    //     public function index(): Response
    //     {


    //         return $this->render('stripe/index.html.twig', [
    //             'stripe_key' => $_ENV["STRIPE_KEY"],
    //         ]);
    //     }


    //     #[Route('/stripe/create-charge', name: 'app_stripe_charge', methods: ['POST'])]
    //     public function createCharge(Request $request)
    //     {
    //         $subscriptionType = $request->request->get('subscription_type');

    //         if ($subscriptionType === 'monthly') {
    //             $amount = 23.99*100;
    //         } elseif ($subscriptionType === 'annual') {
    //             $amount = 259.10*100;
    //         }
    //         Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
    //         Stripe\Charge::create ([
    //                 "amount" => $amount,
    //                 "currency" => "eur",
    //                 "source" => $request->request->get('stripeToken'),
    //                 "description" => "Binaryboxtuts Payment Test"
    //         ]);
    //         $this->addFlash(
    //             'success',
    //             'Payment Successful!'
    //         );
    //         return $this->redirectToRoute('app_stripe', [], Response::HTTP_SEE_OTHER);
    //     }
