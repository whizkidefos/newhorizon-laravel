<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\WorkHistory;

class EditWorkHistory extends Component
{
    public WorkHistory $workHistory;
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

    public function mount(WorkHistory $workHistory)
    {
        $this->workHistory = $workHistory;
        $this->company_name = $workHistory->company_name;
        $this->job_title = $workHistory->job_title;
        $this->start_date = $workHistory->start_date->format('Y-m');
        $this->end_date = $workHistory->end_date ? $workHistory->end_date->format('Y-m') : null;
        $this->responsibilities = $workHistory->responsibilities;
        $this->reference_name = $workHistory->reference_name;
        $this->reference_contact = $workHistory->reference_contact;
    }

    public function save()
    {
        $this->validate();

        $this->workHistory->update([
            'company_name' => $this->company_name,
            'job_title' => $this->job_title,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'responsibilities' => $this->responsibilities,
            'reference_name' => $this->reference_name,
            'reference_contact' => $this->reference_contact,
        ]);

        $this->emit('workHistoryUpdated');
        $this->emit('closeModal');
    }

    public function render()
    {
        return view('profile.work-history.edit-work-history');
    }
}
