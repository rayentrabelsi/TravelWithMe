<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function index(): Response
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }


#[Route('/checkout', name: 'checkout')]
public function checkout(): Response
{
    \Stripe\Stripe::setApiKey('sk_test_51OpuJwKvIA0EH3EDkYzwptoDQpQQy0POJNeH8NU0zhsknV3OzCxJaUA1urrYWmuyNEcgDVbjC23x02sJlgq5fHJx001xX60TqK');

    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items'           => [[
            'price_data' => [
                'currency'     => 'usd',
                'product_data' => [
                    'name' => 'Accomodation',
                ],
                'unit_amount' => 2000,
            ],
            'quantity' => 1,
        ]],
        'mode'          => 'payment',
        'success_url'    => $this -> generateUrl('success_url',[], UrlGeneratorInterface::ABSOLUTE_URL ),
        'cancel_url'     => $this -> generateUrl('cancel_url', [] ,UrlGeneratorInterface::ABSOLUTE_URL ),
        ]);    
    
     return $this->redirect($session->url,303);    

}

#[Route('/success-url', name: 'success_url')]
public function successUrl(): Response
{
    return $this->render('payment/success.html.twig', []);
}


#[Route('/cancel-url', name: 'cancel_url')]
public function cancelUrl(): Response
{
    return $this->render('payment/cancel.html.twig', []);
}



}
