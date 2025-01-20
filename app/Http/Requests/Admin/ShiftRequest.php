<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ShiftRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_datetime' => 'required|date|after:now',
            'end_datetime' => 'required|date|after:start_datetime',
            'location' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'rate_per_hour' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:open,assigned,completed,cancelled'
        ];
    }
}