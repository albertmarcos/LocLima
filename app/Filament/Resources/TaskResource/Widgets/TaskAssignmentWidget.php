<?php

namespace App\Filament\Resources\TaskResource\Widgets;

use App\Models\Task;
use Filament\Widgets\ChartWidget;

class TaskAssignmentWidget extends ChartWidget
{
    protected static ?string $heading = 'Tarefas';

    protected function getData(): array
    {
        $assignedCount = Task::whereNotNull('responsible_id')->count();
        $unassignedCount = Task::whereNull('responsible_id')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Tarefas',
                    'data' => [$assignedCount, $unassignedCount],
                    'backgroundColor' => [
                        '#36A2EB',
                        '#FF6384',
                    ],
                ],
            ],
            'labels' => ['Atribuídas', 'Não Atribuídas'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
