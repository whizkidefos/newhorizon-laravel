<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Terms & Conditions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="prose dark:prose-invert max-w-none">
                        <h2>Terms and Conditions for New Horizon Healthcare</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Last updated: {{ now()->format('F d, Y') }}</p>

                        <h3>1. Agreement to Terms</h3>
                        <p>By accessing our website and using our services, you agree to be bound by these Terms and Conditions and our Privacy Policy.</p>

                        <h3>2. Healthcare Professional Requirements</h3>
                        <p>To use our services as a healthcare professional, you must:</p>
                        <ul>
                            <li>Hold valid professional qualifications</li>
                            <li>Maintain current registration with relevant regulatory bodies</li>
                            <li>Have a valid DBS certificate</li>
                            <li>Provide accurate information about your experience and qualifications</li>
                            <li>Comply with all relevant healthcare regulations and standards</li>
                        </ul>

                        <h3>3. Booking and Attendance</h3>
                        <p>When accepting shifts, you agree to:</p>
                        <ul>
                            <li>Arrive on time for all scheduled shifts</li>
                            <li>Provide adequate notice for cancellations</li>
                            <li>Complete all required documentation</li>
                            <li>Follow facility policies and procedures</li>
                        </ul>

                        <h3>4. Payment Terms</h3>
                        <ul>
                            <li>Payment rates will be clearly communicated before shift acceptance</li>
                            <li>Timesheets must be submitted accurately and on time</li>
                            <li>Payment will be made according to our standard payment schedule</li>
                            <li>Any disputes must be raised within 30 days</li>
                        </ul>

                        <h3>5. Code of Conduct</h3>
                        <p>You agree to:</p>
                        <ul>
                            <li>Maintain professional behavior at all times</li>
                            <li>Respect patient confidentiality</li>
                            <li>Follow health and safety guidelines</li>
                            <li>Report any incidents or concerns promptly</li>
                        </ul>

                        <h3>6. Termination</h3>
                        <p>We reserve the right to terminate services if you:</p>
                        <ul>
                            <li>Breach these terms and conditions</li>
                            <li>Provide false information</li>
                            <li>Fail to maintain required qualifications</li>
                            <li>Receive serious complaints about your service</li>
                        </ul>

                        <h3>7. Changes to Terms</h3>
                        <p>We may update these terms from time to time. Continued use of our services after changes constitutes acceptance of new terms.</p>

                        <h3>8. Contact Information</h3>
                        <p>For questions about these terms, contact us at:</p>
                        <p>Email: info@newhorizonhealthcare.co.uk<br>
                        Phone: [Your Phone Number]<br>
                        Address: [Your Address]</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
