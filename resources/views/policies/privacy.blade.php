<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Privacy Policy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="prose dark:prose-invert max-w-none">
                        <h2>Privacy Policy for New Horizon Healthcare</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Last updated: {{ now()->format('F d, Y') }}</p>

                        <h3>1. Introduction</h3>
                        <p>New Horizon Healthcare ("we", "our", or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our website and services.</p>

                        <h3>2. Information We Collect</h3>
                        <p>We collect information that you provide directly to us, including:</p>
                        <ul>
                            <li>Personal identification information (name, email address, phone number, etc.)</li>
                            <li>Professional credentials and qualifications</li>
                            <li>Employment history and references</li>
                            <li>Banking and payment information</li>
                            <li>Documents such as DBS certificates and identification</li>
                        </ul>

                        <h3>3. How We Use Your Information</h3>
                        <p>We use the information we collect to:</p>
                        <ul>
                            <li>Process your registration and maintain your account</li>
                            <li>Match you with appropriate healthcare positions</li>
                            <li>Process payments and manage timesheets</li>
                            <li>Communicate with you about shifts and opportunities</li>
                            <li>Ensure compliance with healthcare regulations</li>
                        </ul>

                        <h3>4. Information Sharing</h3>
                        <p>We may share your information with:</p>
                        <ul>
                            <li>Healthcare facilities where you work</li>
                            <li>Regulatory bodies when required</li>
                            <li>Payment processors for handling payments</li>
                        </ul>

                        <h3>5. Data Security</h3>
                        <p>We implement appropriate security measures to protect your personal information. However, no method of transmission over the internet is 100% secure.</p>

                        <h3>6. Your Rights</h3>
                        <p>You have the right to:</p>
                        <ul>
                            <li>Access your personal information</li>
                            <li>Correct inaccurate information</li>
                            <li>Request deletion of your information</li>
                            <li>Object to processing of your information</li>
                        </ul>

                        <h3>7. Contact Us</h3>
                        <p>If you have questions about this Privacy Policy, please contact us at:</p>
                        <p>Email: privacy@newhorizonhealthcare.co.uk<br>
                        Phone: [Your Phone Number]<br>
                        Address: [Your Address]</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
