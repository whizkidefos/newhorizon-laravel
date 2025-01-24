<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\WorkHistory;

class AddWorkHistory extends Component
{
    public $company_name;
    public $job_title;
    public $start_date;
    public $end_date;
    public $responsibilities;
    public $reference_name;
    public $reference_contact;

    protected $rules = [
        'company_name' => 'required|string|max:255',
        'job_title' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after:start_date',
        'responsibilities' => 'nullable|string',
        'reference_name' => 'nullable|string|max:255',
        'reference_contact' => 'nullable|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        auth()->user()->workHistory()->create([
            'company_name' => $this->company_name,
            'job_title' => $this->job_title,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'responsibilities' => $this->responsibilities,
            'reference_name' => $this->reference_name,
            'reference_contact' => $this->reference_contact,
        ]);

        $this->emit('workHistoryAdded');
        $this->emit('closeModal');
    }

    public function render()
    {
        return view('profile.work-history.add-work-history');
    }
}
