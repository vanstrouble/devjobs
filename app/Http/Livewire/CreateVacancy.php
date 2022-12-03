<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Salary;
use App\Models\Vacancy;
use Livewire\Component;
use Livewire\WithFileUploads;

class createVacancy extends Component
{
    public $title;
    public $salary;
    public $category;
    public $company;
    public $last_day;
    public $description;
    public $image;

    use WithFileUploads;

    protected $rules = [
        'title' => 'required|string',
        'salary' => 'required',
        'category' => 'required',
        'company' => 'required',
        'last_day' => 'required',
        'description' => 'required',
        'image' => 'required|image|max:1024',
    ];

    public function createVacancy()
    {
        $data = $this->validate();

        // Save the image
        $image = $this->image->store('public/vacancies');
        $data['image'] = str_replace('public/vacancies/', '', $image);

        // dd($image_name);
        // Create vacancy
        Vacancy::create([
            'title' => $data['title'],
            'salary_id' => $data['salary'],
            'category_id' => $data['category'],
            'company' => $data['company'],
            'last_day' => $data['last_day'],
            'description' => $data['description'],
            'image' => $data['image'],
            'user_id' => auth()->user()->id,
        ]);

        // Message to user
        session()->flash('message', 'La vacante se publicó correctamente.');

        // Redirect to user
        return redirect()->route('vacancies.index');
    }

    public function render()
    {
        $salaries = Salary::all();
        $categories = Category::all();
        return view('livewire.create-vacancy', [
            'salaries' => $salaries,
            'categories' => $categories
        ]);
    }
}
