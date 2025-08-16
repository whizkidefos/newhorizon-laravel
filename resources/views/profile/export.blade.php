<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Export Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('profile.export.download') }}" class="space-y-6">
                        @csrf

                        <div>
                            <h3 class="text-lg font-medium">{{ __('Select Export Format') }}</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Choose the format you want to export your profile data in.') }}
                            </p>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-center">
                                    <input id="format-pdf" name="format" type="radio" value="pdf" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" checked>
                                    <label for="format-pdf" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        PDF
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="format-excel" name="format" type="radio" value="excel" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <label for="format-excel" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Excel
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="format-csv" name="format" type="radio" value="csv" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <label for="format-csv" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        CSV
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-medium">{{ __('Select Fields to Export') }}</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Choose which information you want to include in your export.') }}
                            </p>
                            
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="space-y-4">
                                    <h4 class="font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Personal Information') }}</h4>
                                    
                                    <div class="flex items-center">
                                        <input id="field-first_name" name="columns[]" type="checkbox" value="first_name" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" checked>
                                        <label for="field-first_name" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            First Name
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="field-last_name" name="columns[]" type="checkbox" value="last_name" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" checked>
                                        <label for="field-last_name" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Last Name
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="field-email" name="columns[]" type="checkbox" value="email" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" checked>
                                        <label for="field-email" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Email
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="field-username" name="columns[]" type="checkbox" value="username" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="field-username" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Username
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="field-mobile_number" name="columns[]" type="checkbox" value="mobile_number" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" checked>
                                        <label for="field-mobile_number" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Mobile Number
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="field-date_of_birth" name="columns[]" type="checkbox" value="date_of_birth" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="field-date_of_birth" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Date of Birth
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="field-gender" name="columns[]" type="checkbox" value="gender" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="field-gender" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Gender
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <h4 class="font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Professional Information') }}</h4>
                                    
                                    <div class="flex items-center">
                                        <input id="field-job_role" name="columns[]" type="checkbox" value="job_role" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" checked>
                                        <label for="field-job_role" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Job Role
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="field-national_insurance_number" name="columns[]" type="checkbox" value="national_insurance_number" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" checked>
                                        <label for="field-national_insurance_number" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            National Insurance Number
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="field-nationality" name="columns[]" type="checkbox" value="nationality" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" checked>
                                        <label for="field-nationality" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Nationality
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="field-right_to_work_uk" name="columns[]" type="checkbox" value="right_to_work_uk" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="field-right_to_work_uk" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Right to Work in UK
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="field-has_enhanced_dbs" name="columns[]" type="checkbox" value="has_enhanced_dbs" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="field-has_enhanced_dbs" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Enhanced DBS Status
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="field-has_criminal_convictions" name="columns[]" type="checkbox" value="has_criminal_convictions" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="field-has_criminal_convictions" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Criminal Convictions
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <h4 class="font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Other Information') }}</h4>
                                    
                                    <div class="flex items-center">
                                        <input id="field-address" name="columns[]" type="checkbox" value="address" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" checked>
                                        <label for="field-address" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Full Address
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="field-employee_id" name="columns[]" type="checkbox" value="employee_id" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="field-employee_id" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Employee ID
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="field-department" name="columns[]" type="checkbox" value="department" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="field-department" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Department
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="field-position" name="columns[]" type="checkbox" value="position" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="field-position" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Position
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="field-created_at" name="columns[]" type="checkbox" value="created_at" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="field-created_at" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            Account Created Date
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Export Profile') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
