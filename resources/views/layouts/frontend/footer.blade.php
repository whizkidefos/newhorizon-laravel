<footer class="bg-gray-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="col-span-1 md:col-span-2">
                <h3 class="text-lg font-semibold mb-4">New Horizon Healthcare</h3>
                <p class="text-gray-300 mb-4">Leading provider of healthcare staffing solutions in North Wales and North West England.</p>
                <div class="flex space-x-4">
                    <!-- Social Media Links -->
                    <a href="#" class="text-gray-300 hover:text-white">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <!-- Facebook icon -->
                        </svg>
                    </a>
                    <!-- Add other social media icons -->
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white">Home</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-white">About</a></li>
                    <li><a href="{{ route('services') }}" class="text-gray-300 hover:text-white">Services</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Contact</h3>
                <ul class="space-y-2 text-gray-300">
                    <li>123 Healthcare Street</li>
                    <li>Chester, CH1 1AA</li>
                    <li>Tel: 01244 123456</li>
                    <li>Email: info@newhorizon.com</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
            <p>&copy; {{ date('Y') }} New Horizon Healthcare. All rights reserved.</p>
        </div>
    </div>
</footer>