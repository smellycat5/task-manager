<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected Task $task;

    public function __construct(Task $task) {
        $this->task = $task;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=auth()->user();
        $tasks = Task::where('user_id',$user->id)->latest()->get();
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
        Task::create($validated);
        return redirect('dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, Task $task)
    {
        $validated = $request->validated();
        $task->update($validated);
        return redirect('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect('dashboard');
    }

    /**
     * update project status.
     */
    public function status(Request $request)
    {
        $data =$this->task->findorfail($request->id);
        // dd($data);
        if (!$data->status) {
            $data->status = true;
        } else {
            $data->status = false;
        }
        $data->save();
        return redirect('dashboard');
    }
}
