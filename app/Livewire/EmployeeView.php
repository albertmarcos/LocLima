<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class EmployeeView extends Component
{
    public $employee;

    public function mount($id)
    {
        $this->employee = User::withCount(['tasks', 'routines'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.employee-view', [
            'employee' => $this->employee,
        ]);
    }
}
