<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\TrainingRecord;

class AddTrainingRecord extends Component
{
    use WithFileUploads;

    public $course_name;
    public $provider;
    public $completion_date;
    public $expiry_date;
    public $certificate;
    public $notes;

    protected $rules = [
        'course_name' => 'required|string|max:255',
        'provider' => 'required|string|max:255',
        'completion_date' => 'required|date',
        'expiry_date' => 'nullable|date|after:completion_date',
        'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'notes' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        $data = [
            'course_name' => $this->course_name,
            'provider' => $this->provider,
            'completion_date' => $this->completion_date,
            'expiry_date' => $this->expiry_date,
            'notes' => $this->notes,
        ];

        if ($this->certificate) {
            $data['certificate_path'] = $this->certificate->store('certificates', 'public');
        }

        auth()->user()->trainingRecords()->create($data);

        $this->emit('trainingRecordAdded');
        $this->emit('closeModal');
    }

    public function render()
    {
        return view('profile.training.add-training-record');
    }
}
