<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="flex justify-center pt-4">
        <form action={{ route('task.store') }} method="POST">
            @csrf
            <input type="text" class="w-64 px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:border-blue-500" placeholder="Add New Task" name="task">
            <button type="submit"
                class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600">Submit</button>
        </form>
    </div>

        @foreach ($tasks as $task)
        <div class="py-2">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="border border-gray-300 rounded p-4 shadow border-blue   -300">
                    <div class="flex items-center">
                    <input type="checkbox" id="tick" class="form-checkbox h-5 w-5 text-blue-500" onchange="toggleTextDecoration(this.checked)">
                    <label for="tick1" id="label" class="ml-2 text-gray-700">{{ $task->task }}</label>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    {{-- onchange="toggleTextDecoration(this.checked)" --}}
    <script>
        function toggleTextDecoration(checked) {
            var label = document.getElementById("label");
            label.style.textDecoration = checked ? "line-through" : "none";
        }
    </script>
</x-app-layout>
