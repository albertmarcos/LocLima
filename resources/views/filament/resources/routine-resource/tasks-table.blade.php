<!-- filepath: resources/views/filament/resources/routine-resource/tasks-table.blade.php -->
<table class="min-w-full divide-y divide-gray-200">
    <thead>
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Name
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Description
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
            </th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @foreach ($tasks as $task)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ $task->name }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $task->description }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $task->status }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                {{-- <a href="{{ route('filament.resources.tasks.edit', $task) }}"
                    class="text-indigo-600 hover:text-indigo-900">Edit</a> --}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>