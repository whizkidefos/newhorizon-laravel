<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Page Content Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <a href="{{ route('admin.content.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            {{ __('Back to Content Management') }}
                        </a>
                    </div>

                    <h3 class="text-lg font-medium mb-4">{{ __('Edit Page Content') }}</h3>
                    
                    <form method="POST" action="{{ route('admin.content.page-content.update') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Home Page Content -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-6">
                            <h4 class="text-md font-medium mb-4 border-b pb-2">{{ __('Home Page') }}</h4>
                            
                            <div class="mb-4">
                                <x-input-label for="content[home_hero_title]" :value="__('Hero Title')" />
                                <x-text-input id="content[home_hero_title]" name="content[home_hero_title]" type="text" class="mt-1 block w-full" 
                                    value="{{ $pageContents->where('key', 'home_hero_title')->first()->value ?? 'Healthcare Professionals You Can Trust' }}" />
                            </div>
                            
                            <div class="mb-4">
                                <x-input-label for="content[home_hero_subtitle]" :value="__('Hero Subtitle')" />
                                <x-text-input id="content[home_hero_subtitle]" name="content[home_hero_subtitle]" type="text" class="mt-1 block w-full" 
                                    value="{{ $pageContents->where('key', 'home_hero_subtitle')->first()->value ?? 'Providing quality healthcare services across the UK' }}" />
                            </div>
                            
                            <div>
                                <x-input-label for="content[home_about_text]" :value="__('About Section Text')" />
                                <textarea id="content[home_about_text]" name="content[home_about_text]" rows="4" 
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ $pageContents->where('key', 'home_about_text')->first()->value ?? 'New Horizon Healthcare Services is dedicated to providing exceptional healthcare services with a focus on quality, compassion, and professionalism.' }}</textarea>
                            </div>
                        </div>
                        
                        <!-- About Page Content -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-6">
                            <h4 class="text-md font-medium mb-4 border-b pb-2">{{ __('About Page') }}</h4>
                            
                            <div class="mb-4">
                                <x-input-label for="content[about_title]" :value="__('Page Title')" />
                                <x-text-input id="content[about_title]" name="content[about_title]" type="text" class="mt-1 block w-full" 
                                    value="{{ $pageContents->where('key', 'about_title')->first()->value ?? 'About New Horizon Healthcare Services' }}" />
                            </div>
                            
                            <div>
                                <x-input-label for="content[about_content]" :value="__('Main Content')" />
                                <textarea id="content[about_content]" name="content[about_content]" rows="6" 
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ $pageContents->where('key', 'about_content')->first()->value ?? 'New Horizon Healthcare Services was founded with a mission to provide high-quality healthcare staffing solutions across the UK. Our team of dedicated professionals brings years of experience in healthcare delivery and management.' }}</textarea>
                            </div>
                        </div>
                        
                        <!-- Contact Page Content -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-6">
                            <h4 class="text-md font-medium mb-4 border-b pb-2">{{ __('Contact Page') }}</h4>
                            
                            <div class="mb-4">
                                <x-input-label for="content[contact_title]" :value="__('Page Title')" />
                                <x-text-input id="content[contact_title]" name="content[contact_title]" type="text" class="mt-1 block w-full" 
                                    value="{{ $pageContents->where('key', 'contact_title')->first()->value ?? 'Contact Us' }}" />
                            </div>
                            
                            <div class="mb-4">
                                <x-input-label for="content[contact_address]" :value="__('Office Address')" />
                                <textarea id="content[contact_address]" name="content[contact_address]" rows="3" 
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ $pageContents->where('key', 'contact_address')->first()->value ?? '123 Healthcare Avenue, London, UK, W1 1AA' }}</textarea>
                            </div>
                            
                            <div class="mb-4">
                                <x-input-label for="content[contact_email]" :value="__('Contact Email')" />
                                <x-text-input id="content[contact_email]" name="content[contact_email]" type="email" class="mt-1 block w-full" 
                                    value="{{ $pageContents->where('key', 'contact_email')->first()->value ?? 'info@newhorizonhealthcare.co.uk' }}" />
                            </div>
                            
                            <div>
                                <x-input-label for="content[contact_phone]" :value="__('Contact Phone')" />
                                <x-text-input id="content[contact_phone]" name="content[contact_phone]" type="text" class="mt-1 block w-full" 
                                    value="{{ $pageContents->where('key', 'contact_phone')->first()->value ?? '+44 20 1234 5678' }}" />
                            </div>
                        </div>
                        
                        <!-- Footer Content -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-6">
                            <h4 class="text-md font-medium mb-4 border-b pb-2">{{ __('Footer') }}</h4>
                            
                            <div class="mb-4">
                                <x-input-label for="content[footer_copyright]" :value="__('Copyright Text')" />
                                <x-text-input id="content[footer_copyright]" name="content[footer_copyright]" type="text" class="mt-1 block w-full" 
                                    value="{{ $pageContents->where('key', 'footer_copyright')->first()->value ?? '© 2025 New Horizon Healthcare Services. All rights reserved.' }}" />
                            </div>
                            
                            <div>
                                <x-input-label for="content[footer_tagline]" :value="__('Footer Tagline')" />
                                <x-text-input id="content[footer_tagline]" name="content[footer_tagline]" type="text" class="mt-1 block w-full" 
                                    value="{{ $pageContents->where('key', 'footer_tagline')->first()->value ?? 'Dedicated to healthcare excellence' }}" />
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                {{ __('Save All Content') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        // Initialize any rich text editors if needed
        document.addEventListener('DOMContentLoaded', function() {
            // You can add code here to initialize a WYSIWYG editor for textareas
        });
    </script>
    @endpush
</x-app-layout>
