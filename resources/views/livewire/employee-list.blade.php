<div class="pt-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach ($employees as $employee)
        <div class="bg-white shadow rounded-lg p-4 w-full transition-all duration-300" id="card-{{ $employee->id }}">
            <h2 class="text-xl font-bold text-center">{{ $employee->name }}</h2>
            <div class="flex justify-between text-gray-600 mt-4 text-lg mb-5">
                <p>Tarefas: {{ $employee->tasks_count }}</p>
                <p>Rotas: {{ $employee->routines_count }}</p>
            </div>

            <a href="{{ route('filament.admin.resources.employees.view', $employee) }}"
                class="mt-4 w-full bg-primary-600 text-white text-sm font-semibold py-2 px-4 rounded-lg transition duration-200 ease-in-out focus:outline-none">
                Ver Detalhes
            </a>
        </div>
        @endforeach
    </div>
</div>