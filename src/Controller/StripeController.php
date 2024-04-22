<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Stripe;
 
class StripeController extends AbstractController
{

    #[Route('/choose-subscription', name: 'choose_subscription')]
public function chooseSubscription(): Response
{
    return $this->render('stripe/choose-subscription.html.twig');
}


#[Route('/payment-information', name: 'payment_information', methods: ['POST'])]
public function paymentInformation(Request $request): Response
{

    $subscriptionType = $request->request->get('abonnement');
    $amount = $subscriptionType === 'annuel' ? 25908 : 2399; 


    $session = $request->getSession();
    $session->set('subscription_type', $subscriptionType);
    $session->set('amount', $amount);


    return $this->render('stripe/payment-information.html.twig', [
        'stripe_key' => $_ENV["STRIPE_KEY"],
        'amount' => $amount / 100, 
        'subscriptionType' => $subscriptionType
    ]);
}
    #[Route('/stripe', name: 'app_stripe')]
    public function index(): Response
    {

        
        return $this->render('stripe/index.html.twig', [
            'stripe_key' => $_ENV["STRIPE_KEY"],
        ]);
    }
 
 
    #[Route('/stripe/create-charge', name: 'app_stripe_charge', methods: ['POST'])]
    public function createCharge(Request $request)
    {
        $subscriptionType = $request->request->get('subscription_type');
        
        if ($subscriptionType === 'monthly') {
            $amount = 23.99*100;
        } elseif ($subscriptionType === 'annual') {
            $amount = 259.10*100;
        }
        Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
        Stripe\Charge::create ([
                "amount" => $amount,
                "currency" => "eur",
                "source" => $request->request->get('stripeToken'),
                "description" => "Binaryboxtuts Payment Test"
        ]);
        $this->addFlash(
            'success',
            'Payment Successful!'
        );
        return $this->redirectToRoute('app_stripe', [], Response::HTTP_SEE_OTHER);
    }

    
}
