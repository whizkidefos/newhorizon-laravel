<div>
    <form wire:submit.prevent="save">
        <div class="px-6 py-4">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Add Training Record') }}
            </h2>

            <div class="mt-4">
                <x-input-label for="course_name" :value="__('Course Name')" />
                <x-text-input wire:model="course_name" id="course_name" type="text" class="block w-full mt-1" required />
                <x-input-error :messages="$errors->get('course_name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="provider" :value="__('Provider')" />
                <x-text-input wire:model="provider" id="provider" type="text" class="block w-full mt-1" required />
                <x-input-error :messages="$errors->get('provider')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="completion_date" :value="__('Completion Date')" />
                <x-text-input wire:model="completion_date" id="completion_date" type="date" class="block w-full mt-1" required />
                <x-input-error :messages="$errors->get('completion_date')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="expiry_date" :value="__('Expiry Date')" />
                <x-text-input wire:model="expiry_date" id="expiry_date" type="date" class="block w-full mt-1" />
                <x-input-error :messages="$errors->get('expiry_date')" class="mt-2" />
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Leave blank if the certificate does not expire</p>
            </div>

            <div class="mt-4">
                <x-input-label for="certificate" :value="__('Certificate')" />
                <input type="file" wire:model="certificate" id="certificate" 
                    class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    accept=".pdf,.jpg,.jpeg,.png">
                <x-input-error :messages="$errors->get('certificate')" class="mt-2" />
                <div wire:loading wire:target="certificate">
                    <p class="mt-2 text-sm text-blue-600">Uploading...</p>
                </div>
            </div>

            <div class="mt-4">
                <x-input-label for="notes" :value="__('Notes')" />
                <textarea wire:model="notes" id="notes" 
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" 
                    rows="3"></textarea>
                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
            </div>
        </div>

        <div class="px-6 py-4 text-right bg-gray-100 dark:bg-gray-800">
            <x-secondary-button wire:click="$emit('closeModal')" class="mr-2">
                {{ __('Cancel') }}
            </x-secondary-button>
            <x-primary-button type="submit">
                {{ __('Save') }}
            </x-primary-button>
        </div>
    </form>
</div>
