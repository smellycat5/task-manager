<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=auth()->user();
        $tasks = Task::where('user_id',$user->id)->get();
        return view('dashboard',compact('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        $validated = $request->validated();
        $user_id = auth()->user()->id;
        $validated['user_id'] = $user_id;
        // dd($validated);
        Task::create($validated);
        return redirect('dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
