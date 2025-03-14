<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class EmployeeList extends Component
{
    public $employees;

    public function mount()
    {
        $this->employees = User::where('type', 'employee')
            ->withCount(['tasks' => function ($query) {
            $query->where('done', 0);
            }, 'routines' => function ($query) {
            $query->where('done', 0);
            }])
            ->get();

        // dd($this->employees);


    }

    public function render()
    {
        return view('livewire.employee-list', [
            'employees' => $this->employees
        ]);
    }
}
