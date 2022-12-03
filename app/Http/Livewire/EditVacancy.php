<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Salary;
use App\Models\Category;
use App\Models\Vacancy;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class EditVacancy extends Component
{
    public $vacancy_id;
    public $title;
    public $salary;
    public $category;
    public $company;
    public $last_day;
    public $description;
    public $image;
    public $new_image;

    use WithFileUploads;

    protected $rules = [
        'title' => 'required|string',
        'salary' => 'required',
        'category' => 'required',
        'company' => 'required',
        'last_day' => 'required',
        'description' => 'required',
        'new_image' => 'nullable|image|max:1024',
    ];

    public function mount(Vacancy $vacancy)
    {
        $this->vacancy_id = $vacancy->id;
        $this->title = $vacancy->title;
        $this->salary = $vacancy->salary_id;
        $this->category = $vacancy->category_id;
        $this->company = $vacancy->company;
        $this->last_day = Carbon::parse($vacancy->last_day)->format('Y-m-d');
        $this->description = $vacancy->description;
        $this->image = $vacancy->image;
    }

    public function editVacancy()
    {
        $data = $this->validate();

        // Get new vacancy
        $vacancy = Vacancy::find($this->vacancy_id);

        // Validate new image if exists
        if($this->new_image) {
            $image = $this->new_image->store('public/vacancies');
            $data['image'] = str_replace('public/vacancies/', '', $image);
            Storage::delete('public/vacancies'.$vacancy->image);
        }

        // Set values
        $vacancy->title = $data['title'];
        $vacancy->salary_id = $data['salary'];
        $vacancy->category_id = $data['category'];
        $vacancy->company = $data['company'];
        $vacancy->last_day = $data['last_day'];
        $vacancy->description = $data['description'];
        $vacancy->image = $data['image'] ?? $vacancy->image;


        // Save vacancy data
        $vacancy->save();

        // Redirect to
        session()->flash('message', 'La vacante se actualizó correctamente');
        return redirect()->route('vacancies.index');
    }

    public function render()
    {
        $salaries = Salary::all();
        $categories = Category::all();
        return view('livewire.edit-vacancy', [
            'salaries' => $salaries,
            'categories' => $categories
        ]);
    }
}
