<div class="pt-4">
    <div class="bg-white shadow rounded-lg p-6 w-full max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-center mb-4">{{ $employee->name }}</h2>
        <div class="flex justify-between text-gray-600 text-lg mb-5">
            <p>Tarefas: {{ $employee->tasks_count }}</p>
            <p>Rotas: {{ $employee->routines_count }}</p>
        </div>

        <!-- Rotinas Não Concluídas -->
        @if($employee->routines->where('done', 0)->count() > 0)
        <div class="bg-red-100 shadow rounded-lg p-4 mb-4">
            <p class="text-gray-700 font-semibold mt-2">Rotas Não Concluídas:</p>
            <ul class="list-disc pl-4 text-gray-600 text-sm border-t border-gray-200 pt-2">
                @foreach ($employee->routines->where('done', 0) as $routine)
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    <a href="{{ route('filament.admin.resources.routines.view', $routine->id) }}"
                        class="hover:underline">{{
                        $routine->name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Rotinas Concluídas -->
        @if($employee->routines->where('done', 1)->count() > 0)
        <div class="bg-green-100 shadow rounded-lg p-4 mb-4">
            <p class="text-gray-700 font-semibold mt-2">Rotas Concluídas:</p>
            <ul class="list-disc pl-4 text-gray-600 text-sm border-t border-gray-200 pt-2">
                @foreach ($employee->routines->where('done', 1) as $routine)
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <a href="{{ route('filament.admin.resources.routines.view', $routine->id) }}"
                        class="hover:underline">{{
                        $routine->name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Tarefas Não Concluídas -->
        @if($employee->tasks->where('done', 0)->count() > 0)
        <div class="bg-red-100 shadow rounded-lg p-4 mb-4">
            <p class="text-gray-700 font-semibold mt-2">Tarefas Não Concluídas:</p>
            <ul class="list-disc pl-4 text-gray-600 text-sm border-t border-gray-200 pt-2">
                @foreach ($employee->tasks->where('done', 0) as $task)
                <li class="flex items-center p-1">
                    <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    <a href="{{ route('filament.admin.resources.tasks.edit', $task->id) }}" class="hover:underline">{{
                        $task->name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Tarefas Concluídas -->
        @if($employee->tasks->where('done', 1)->count() > 0)
        <div class="bg-green-100 shadow rounded-lg p-4 mb-4">
            <p class="text-gray-700 font-semibold mt-2">Tarefas Concluídas:</p>
            <ul class="list-disc pl-4 text-gray-600 text-sm border-t border-gray-200 pt-2">
                @foreach ($employee->tasks->where('done', 1) as $task)
                <li class="flex items-center p-1">
                    <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <a href="{{ route('filament.admin.resources.tasks.edit', $task->id) }}" class="hover:underline">{{
                        $task->name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>