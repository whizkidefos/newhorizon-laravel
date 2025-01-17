<?php

namespace App\Services\Payment;

use Stripe\Stripe;
use PayPal\Api\Payment;

class PaymentProcessor
{
    public function processStripePayment($token, $amount)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        return \Stripe\Charge::create([
            'amount' => $amount * 100, // Convert to cents
            'currency' => 'gbp',
            'source' => $token,
            'description' => 'Course payment',
        ]);
    }

    public function processPaypalPayment($paymentId, $payerId)
    {
        $payment = Payment::get($paymentId, $this->apiContext);
        
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        return $payment->execute($execution, $this->apiContext);
    }
}