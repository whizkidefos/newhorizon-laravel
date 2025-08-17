<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Favicon Management') }}
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

                    <h3 class="text-lg font-medium mb-4">{{ __('Current Favicon') }}</h3>
                    
                    <div class="mb-8 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        @if($favicon)
                            <div class="flex flex-col items-center">
                                <img src="{{ Storage::url($favicon) }}" alt="Site Favicon" class="h-16 w-16 mb-4">
                                <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('Current favicon') }}</p>
                            </div>
                        @else
                            <div class="flex items-center justify-center h-16 w-16 mx-auto bg-gray-200 dark:bg-gray-600 rounded">
                                <p class="text-gray-500 dark:text-gray-400">{{ __('None') }}</p>
                            </div>
                        @endif
                    </div>

                    <h3 class="text-lg font-medium mb-4">{{ __('Upload New Favicon') }}</h3>
                    
                    <form method="POST" action="{{ route('admin.content.favicon.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div>
                            <x-input-label for="favicon" :value="__('Favicon File')" />
                            <input type="file" id="favicon" name="favicon" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept="image/*">
                            <x-input-error :messages="$errors->get('favicon')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Recommended size: 32x32 or 16x16 pixels. Max file size: 1MB. Supported formats: ICO, PNG, JPG, SVG.') }}
                            </p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('The image will be automatically resized to 32x32 pixels and converted to the appropriate format.') }}
                            </p>
                        </div>
                        
                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                {{ __('Update Favicon') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
