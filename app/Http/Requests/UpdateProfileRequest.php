<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        \Log::info('UpdateProfileRequest data:', $this->all());

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'mobile_number' => ['required', 'string', 'max:20'],
            'job_role' => ['required', 'string', 'in:registered_nurse,healthcare_assistant,support_worker'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'string', 'in:male,female,other,prefer_not_to_say'],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // 2MB max
            'national_insurance_number' => ['required', 'string', 'max:9', Rule::unique('users')->ignore($this->user()->id)],
            'has_enhanced_dbs' => ['nullable', 'boolean'],
            'dbs_certificate' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // 5MB max
            'nationality' => ['required', 'string', 'max:255'],
            'right_to_work_uk' => ['nullable', 'boolean'],
            'brp_number' => ['nullable', 'required_if:nationality,!=,British', 'string', 'max:255'],
            'brp_document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // 5MB max
            'has_criminal_convictions' => ['nullable', 'boolean'],
            'signature' => ['nullable', 'image', 'max:2048'], // 2MB max
            
            // Address fields (optional)
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'county' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'string', 'max:10'],
            
            // Employment details fields
            'employee_id' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'has_enhanced_dbs' => $this->boolean('has_enhanced_dbs'),
            'right_to_work_uk' => $this->boolean('right_to_work_uk'),
            'has_criminal_convictions' => $this->boolean('has_criminal_convictions'),
        ]);
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'This email is already in use by another account.',
            'username.unique' => 'This username is already taken.',
            'national_insurance_number.unique' => 'This National Insurance number is already registered.',
            'profile_photo.max' => 'The profile photo must not be larger than 2MB.',
            'dbs_certificate.max' => 'The DBS certificate must not be larger than 5MB.',
            'brp_document.max' => 'The BRP document must not be larger than 5MB.',
            'signature.max' => 'The signature must not be larger than 2MB.',
            'brp_number.required_if' => 'The BRP number is required for non-British nationals.',
        ];
    }
}
