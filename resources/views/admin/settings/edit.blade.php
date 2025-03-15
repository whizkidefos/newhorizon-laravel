<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Application Settings') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Company Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Company Information</h3>
                                
                                <div>
                                    <x-input-label for="company_name" :value="__('Company Name')" />
                                    <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" :value="old('company_name')" />
                                    <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="company_email" :value="__('Company Email')" />
                                    <x-text-input id="company_email" name="company_email" type="email" class="mt-1 block w-full" :value="old('company_email')" />
                                    <x-input-error :messages="$errors->get('company_email')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="company_phone" :value="__('Company Phone')" />
                                    <x-text-input id="company_phone" name="company_phone" type="text" class="mt-1 block w-full" :value="old('company_phone')" />
                                    <x-input-error :messages="$errors->get('company_phone')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="company_address" :value="__('Company Address')" />
                                    <x-textarea id="company_address" name="company_address" class="mt-1 block w-full" rows="3">{{ old('company_address') }}</x-textarea>
                                    <x-input-error :messages="$errors->get('company_address')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="company_logo" :value="__('Company Logo')" />
                                    <input type="file" id="company_logo" name="company_logo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                    <x-input-error :messages="$errors->get('company_logo')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Site Settings -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Site Settings</h3>
                                
                                <div>
                                    <x-input-label for="site_title" :value="__('Site Title')" />
                                    <x-text-input id="site_title" name="site_title" type="text" class="mt-1 block w-full" :value="old('site_title')" />
                                    <x-input-error :messages="$errors->get('site_title')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="site_description" :value="__('Site Description')" />
                                    <x-textarea id="site_description" name="site_description" class="mt-1 block w-full" rows="3">{{ old('site_description') }}</x-textarea>
                                    <x-input-error :messages="$errors->get('site_description')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="footer_text" :value="__('Footer Text')" />
                                    <x-textarea id="footer_text" name="footer_text" class="mt-1 block w-full" rows="3">{{ old('footer_text') }}</x-textarea>
                                    <x-input-error :messages="$errors->get('footer_text')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Save Settings') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
