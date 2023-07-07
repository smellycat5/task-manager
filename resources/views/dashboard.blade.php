<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    {{-- add task --}}
    <div class="flex justify-center pt-4">
        <form action="{{ route('task.store') }}" method="POST">
            @csrf
            <input type="text" class="w-64 px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:border-blue-500"
                placeholder="Add New Task" name="task" maxlength="80">
            <input type="hidden" name="status" value=0>
            <button type="submit"
                class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600">Submit</button>
        </form>
    </div>
    {{-- end add task --}}

    @foreach ($tasks as $task)
        <div class="py-2">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="border border-gray-300 rounded p-4 shadow border-blue-300">
                    <div class="flex ">
                        <form action="{{ route('task.status', $task->id) }}" method="POST">
                            @csrf
                            <input type="checkbox" id="tick" class="form-checkbox h-5 w-5 text-blue-500 rounded"
                                name="isChecked" onchange="this.form.submit()"
                                {{ $task->status == 1 ? 'checked' : '' }}>
                        </form>
                        <div id="editContainer" class="flex items-center">
                            @if ($task->status == 0)
                                <span id="taskLabel" class="ml-2 text-gray-700">{{ $task->task }}</span>
                            @else
                                <span id="taskLabel" class="ml-2 text-gray-700 line-through">{{ $task->task }}</span>
                            @endif

                            {{-- edit task --}}
                            <button id="editButton"
                                class="text-gray-500 cursor-pointer p-1 rounded bg-transparent hover:bg-gray-200 focus:outline-none"
                                aria-label="Edit" onclick="enableEdit(this)">
                                <i class="fas fa-pencil-alt"></i>
                            </button>

                            <form id="editForm" class="hidden ml-2" action="{{ route('task.update', $task->id) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <input id="taskInput" type="text" name="task" value="{{ $task->task }}"
                                    class="border border-gray-300 rounded px-2 py-1 focus:outline-none focus:border-blue-500" maxlength="70">
                                <button type="submit" class="text-gray-500 cursor-pointer p-1" aria-label="Save">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                        {{-- delete task --}}
                        <div class="ml-auto flex">
                            <form action="{{ route('task.destroy', $task->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-gray-500 cursor-pointer p-1 rounded bg-transparent hover:bg-gray-200 focus:outline-none"
                                    aria-label="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        function enableEdit(editButton) {
            const editContainer = editButton.parentNode;
            const taskLabel = editContainer.querySelector('#taskLabel');
            const editForm = editContainer.querySelector('#editForm');
            const taskInput = editForm.querySelector('#taskInput');

            taskInput.value = taskLabel.innerText;
            editContainer.classList.add('editing');
            taskLabel.classList.add('hidden');
            editForm.classList.remove('hidden');
            taskInput.focus();
        }

        const editButton = document.getElementById('editButton');
        editButton.addEventListener('click', function(event) {
            event.stopPropagation();
            enableEdit(this);
        });

        document.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                const editContainers = document.querySelectorAll('.editing');
                editContainers.forEach(function(container) {
                    disableEdit(container);
                });
            }
        });

        document.addEventListener('click', function(event) {
            const editContainers = document.querySelectorAll('.editing');
            editContainers.forEach(function(container) {
                if (!container.contains(event.target)) {
                    disableEdit(container);
                }
            });
        });

        function disableEdit(editContainer) {
            const taskLabel = editContainer.querySelector('#taskLabel');
            const editForm = editContainer.querySelector('#editForm');

            taskLabel.classList.remove('hidden');
            editForm.classList.add('hidden');
            editContainer.classList.remove('editing');
        }
    </script>
</x-app-layout>
