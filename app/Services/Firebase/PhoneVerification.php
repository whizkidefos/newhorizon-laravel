<?php

namespace App\Services\Firebase;

use Kreait\Firebase\Factory;

class PhoneVerification
{
    protected $firebase;

    public function __construct()
    {
        $this->firebase = (new Factory)
            ->withServiceAccount(storage_path('firebase-credentials.json'))
            ->createAuth();
    }

    public function sendCode($phoneNumber)
    {
        return $this->firebase->signInWithPhoneNumber($phoneNumber);
    }

    public function verifyCode($sessionInfo, $code)
    {
        try {
            $this->firebase->verifyPhoneNumber([
                'sessionInfo' => $sessionInfo,
                'code' => $code,
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}