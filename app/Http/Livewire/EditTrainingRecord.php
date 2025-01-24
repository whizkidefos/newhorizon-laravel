<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\TrainingRecord;
use Illuminate\Support\Facades\Storage;

class EditTrainingRecord extends Component
{
    use WithFileUploads;

    public TrainingRecord $record;
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

    public function mount(TrainingRecord $record)
    {
        $this->record = $record;
        $this->course_name = $record->course_name;
        $this->provider = $record->provider;
        $this->completion_date = $record->completion_date->format('Y-m-d');
        $this->expiry_date = $record->expiry_date ? $record->expiry_date->format('Y-m-d') : null;
        $this->notes = $record->notes;
    }

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
            if ($this->record->certificate_path) {
                Storage::disk('public')->delete($this->record->certificate_path);
            }
            $data['certificate_path'] = $this->certificate->store('certificates', 'public');
        }

        $this->record->update($data);

        $this->emit('trainingRecordUpdated');
        $this->emit('closeModal');
    }

    public function render()
    {
        return view('profile.training.edit-training-record');
    }
}
