<div>
    <form wire:submit.prevent="save">
        <div class="px-6 py-4">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Add Work History') }}
            </h2>

            <div class="mt-4">
                <x-input-label for="company_name" :value="__('Company Name')" />
                <x-text-input wire:model="company_name" id="company_name" type="text" class="block w-full mt-1" required />
                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="job_title" :value="__('Job Title')" />
                <x-text-input wire:model="job_title" id="job_title" type="text" class="block w-full mt-1" required />
                <x-input-error :messages="$errors->get('job_title')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="start_date" :value="__('Start Date')" />
                <x-text-input wire:model="start_date" id="start_date" type="month" class="block w-full mt-1" required />
                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="end_date" :value="__('End Date')" />
                <x-text-input wire:model="end_date" id="end_date" type="month" class="block w-full mt-1" />
                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Leave blank if this is your current job</p>
            </div>

            <div class="mt-4">
                <x-input-label for="responsibilities" :value="__('Responsibilities')" />
                <textarea wire:model="responsibilities" id="responsibilities" 
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" 
                    rows="3"></textarea>
                <x-input-error :messages="$errors->get('responsibilities')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="reference_name" :value="__('Reference Name')" />
                <x-text-input wire:model="reference_name" id="reference_name" type="text" class="block w-full mt-1" />
                <x-input-error :messages="$errors->get('reference_name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="reference_contact" :value="__('Reference Contact')" />
                <x-text-input wire:model="reference_contact" id="reference_contact" type="text" class="block w-full mt-1" />
                <x-input-error :messages="$errors->get('reference_contact')" class="mt-2" />
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
