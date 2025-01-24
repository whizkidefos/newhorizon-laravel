<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Bank Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('profile.bank-details.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="max-w-xl">
                            <!-- Account Holder Name -->
                            <div class="mt-4">
                                <x-input-label for="account_holder_name" :value="__('Account Holder Name')" />
                                <x-text-input id="account_holder_name" name="account_holder_name" type="text" class="block w-full mt-1" 
                                    :value="old('account_holder_name', optional($bankDetails)->account_holder_name)" required />
                                <x-input-error :messages="$errors->get('account_holder_name')" class="mt-2" />
                            </div>

                            <!-- Bank Name -->
                            <div class="mt-4">
                                <x-input-label for="bank_name" :value="__('Bank Name')" />
                                <x-text-input id="bank_name" name="bank_name" type="text" class="block w-full mt-1" 
                                    :value="old('bank_name', optional($bankDetails)->bank_name)" required />
                                <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                            </div>

                            <!-- Account Number -->
                            <div class="mt-4">
                                <x-input-label for="account_number" :value="__('Account Number')" />
                                <x-text-input id="account_number" name="account_number" type="text" class="block w-full mt-1" 
                                    :value="old('account_number', optional($bankDetails)->account_number)" required 
                                    pattern="[0-9]{8}" title="Please enter a valid 8-digit account number" />
                                <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Must be 8 digits</p>
                            </div>

                            <!-- Sort Code -->
                            <div class="mt-4">
                                <x-input-label for="sort_code" :value="__('Sort Code')" />
                                <x-text-input id="sort_code" name="sort_code" type="text" class="block w-full mt-1" 
                                    :value="old('sort_code', optional($bankDetails)->sort_code)" required 
                                    pattern="[0-9]{2}-[0-9]{2}-[0-9]{2}" title="Please enter a valid sort code in the format XX-XX-XX" />
                                <x-input-error :messages="$errors->get('sort_code')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Format: XX-XX-XX</p>
                            </div>

                            <!-- Bank Address -->
                            <div class="mt-4">
                                <x-input-label for="bank_address" :value="__('Bank Address')" />
                                <x-text-input id="bank_address" name="bank_address" type="text" class="block w-full mt-1" 
                                    :value="old('bank_address', optional($bankDetails)->bank_address)" required />
                                <x-input-error :messages="$errors->get('bank_address')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortCodeInput = document.querySelector('#sort_code');
            
            sortCodeInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0) {
                    value = value.match(new RegExp('.{1,2}', 'g')).join('-');
                }
                e.target.value = value;
            });

            const accountNumberInput = document.querySelector('#account_number');
            
            accountNumberInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '').substr(0, 8);
            });
        });
    </script>
    @endpush
</x-app-layout>
