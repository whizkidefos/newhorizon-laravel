<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="col-span-1 md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">New Horizon Healthcare</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Leading provider of healthcare staffing solutions in North Wales and North West England.
                </p>
                <div class="mt-4 space-x-4">
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <!-- Facebook icon path -->
                        </svg>
                    </a>
                    <!-- Add other social media icons as needed -->
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Links</h3>
                <ul class="mt-4 space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                            Services
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                            Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Contact Us</h3>
                <ul class="mt-4 space-y-2">
                    <li class="text-gray-600 dark:text-gray-400">
                        <span class="block">123 Healthcare Street</span>
                        <span class="block">Chester, CH1 1AA</span>
                    </li>
                    <li class="text-gray-600 dark:text-gray-400">
                        Tel: 01244 123456
                    </li>
                    <li class="text-gray-600 dark:text-gray-400">
                        Email: info@newhorizonhealthcare.co.uk
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 dark:text-gray-400">
                    © {{ date('Y') }} New Horizon Healthcare. All rights reserved.
                </p>
                <div class="mt-4 md:mt-0 space-x-4">
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                        Privacy Policy
                    </a>
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                        Terms & Conditions
                    </a>
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                        Cookie Policy
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>