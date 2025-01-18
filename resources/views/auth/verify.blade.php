@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                
                <h2 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">
                    Verify Your Email Address
                </h2>
                
                @if (session('resent'))
                    <div class="mt-4 p-4 bg-green-50 dark:bg-green-900 rounded-md">
                        <p class="text-sm text-green-700 dark:text-green-200">
                            A fresh verification link has been sent to your email address.
                        </p>
                    </div>
                @endif

                <p class="mt-4 text-gray-600 dark:text-gray-400">
                    Before proceeding, please check your email for a verification link.
                    If you didn't receive the email, we can send another.
                </p>

                <form class="mt-6" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Resend Verification Email
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection