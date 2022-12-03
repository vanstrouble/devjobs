<?php

namespace App\Http\Livewire;

use App\Models\Vacancy;
use App\Notifications\NewCandidate;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostulateVacancy extends Component
{
    use WithFileUploads;

    public $cv;
    public $vacancy;

    protected $rules = [
        'cv' => 'required|mimes:pdf'
    ];

    public function mount(Vacancy $vacancy)
    {
        $this->vacancy = $vacancy;
    }

    public function apply()
    {
        $data = $this->validate();

        // Save CV
        $cv = $this->cv->store('public/cv');
        $data['cv'] = str_replace('public/cv/', '', $cv);

        // Create candidate
        $this->vacancy->candidates()->create([
            'user_id' => auth()->user()->id,
            'cv' => $data['cv'],
        ]);

        // Create notification and send email
        $this->vacancy->recruiter->notify(new NewCandidate($this->vacancy->id, $this->vacancy->title, auth()->user()->id));

        // Show OK status to user
        session()->flash('message', 'Se envió correctamente tu información. ¡Mucha suerte!');
        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.postulate-vacancy');
    }
}
