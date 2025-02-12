<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Cookie Policy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="prose dark:prose-invert max-w-none">
                        <h2>Cookie Policy for New Horizon Healthcare</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Last updated: {{ now()->format('F d, Y') }}</p>

                        <h3>1. What Are Cookies</h3>
                        <p>Cookies are small text files that are stored on your computer or mobile device when you visit our website. They help us make the site work better for you.</p>

                        <h3>2. How We Use Cookies</h3>
                        <p>We use cookies for the following purposes:</p>
                        <ul>
                            <li><strong>Essential Cookies:</strong> Required for the website to function properly (e.g., authentication, security)</li>
                            <li><strong>Preference Cookies:</strong> Remember your settings and preferences (e.g., language, theme preferences)</li>
                            <li><strong>Analytics Cookies:</strong> Help us understand how visitors use our site</li>
                            <li><strong>Functionality Cookies:</strong> Enable enhanced features and personalization</li>
                        </ul>

                        <h3>3. Types of Cookies We Use</h3>
                        <h4>Essential Cookies</h4>
                        <ul>
                            <li>Session cookies for authentication</li>
                            <li>CSRF token cookies for security</li>
                            <li>Cookie consent status</li>
                        </ul>

                        <h4>Preference Cookies</h4>
                        <ul>
                            <li>Dark/light mode preference</li>
                            <li>Language selection</li>
                            <li>User interface customizations</li>
                        </ul>

                        <h4>Analytics Cookies</h4>
                        <ul>
                            <li>Google Analytics cookies</li>
                            <li>Usage statistics</li>
                            <li>Performance monitoring</li>
                        </ul>

                        <h3>4. Managing Cookies</h3>
                        <p>You can control and/or delete cookies as you wish. You can:</p>
                        <ul>
                            <li>Delete all cookies from your browser</li>
                            <li>Set your browser to prevent cookies being set</li>
                            <li>Accept or decline cookies when you first visit our site</li>
                        </ul>

                        <p>However, disabling cookies may limit your ability to use certain features of our site.</p>

                        <h3>5. Third-Party Cookies</h3>
                        <p>Some cookies are set by third-party services that appear on our pages:</p>
                        <ul>
                            <li>Google Analytics for website analytics</li>
                            <li>Payment processors for secure transactions</li>
                            <li>Social media plugins if used</li>
                        </ul>

                        <h3>6. Updates to This Policy</h3>
                        <p>We may update this Cookie Policy from time to time. Any changes will be posted on this page with an updated revision date.</p>

                        <h3>7. Contact Us</h3>
                        <p>If you have questions about our Cookie Policy, please contact us:</p>
                        <p>Email: privacy@newhorizonhealthcare.co.uk<br>
                        Phone: [Your Phone Number]<br>
                        Address: [Your Address]</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
