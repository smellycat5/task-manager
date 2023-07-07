<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    {{-- add task --}}
    <div class="flex justify-center pt-4">
        <form action={{ route('task.store') }} method="POST">
            @csrf
            <input type="text"
                class="w-64 px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:border-blue-500"
                placeholder="Add New Task" name="task">
            <button type="submit"
                class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600">Submit</button>
        </form>
    </div>

    @foreach ($tasks as $task)
        <div class="py-2">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="border border-gray-300 rounded p-4 shadow border-blue-300">
                    <div class="flex items-center">
                        <input type="checkbox" id="tick" class="form-checkbox h-5 w-5 text-blue-500"
                            onchange="toggleTextDecoration(this.checked)">

                        {{-- edit task --}}
                        <div id="editContainer" class="flex items-center">
                            <span id="taskLabel" class="ml-2 text-gray-700">{{ $task->task }}</span>
                            <button id="editButton" class="text-gray-500 cursor-pointer p-1" aria-label="Edit"
                                onclick="enableEdit(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-2 2m0 0L15 9m2 2l2-2m0 0l2 2M6 9l-2 2m2-2l2-2m0 2l2 2m-2-2L8 9" />
                                </svg>
                            </button>
                            <form id="editForm" class="hidden ml-2" action="{{ route('task.update', $task->id) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <input id="taskInput" type="text" name="task" value="{{ $task->task }}"
                                    class="border border-gray-300 rounded px-2 py-1 focus:outline-none focus:border-blue-500">
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
                                <button type="submit" class="text-gray-500 cursor-pointer p-1" aria-label="Delete">
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
