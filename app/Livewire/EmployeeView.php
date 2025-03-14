<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Routine;
use App\Models\Task;

class EmployeeView extends Component
{
    public $employee;
    public $unassignedRoutines;
    public $unassignedTasks;

    public function mount($id)
    {
        // Buscar o funcionário com contagem de tarefas e rotinas
        $this->employee = User::withCount(['tasks', 'routines'])->findOrFail($id);

        // Buscar rotinas não atribuídas
        $this->unassignedRoutines = Routine::whereNull('responsible_id')->get();

        // Buscar tarefas não atribuídas
        $this->unassignedTasks = Task::whereNull('responsible_id')->get();
    }

    public function render()
    {
        return view('livewire.employee-view', [
            'employee' => $this->employee,
            'unassignedRoutines' => $this->unassignedRoutines,
            'unassignedTasks' => $this->unassignedTasks,
        ]);
    }
}
