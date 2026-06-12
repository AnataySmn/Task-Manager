<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // GET /api/tasks
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            return Task::all();
        }

        return Task::where('user_id', $user->id)->get();
    }

    // POST /api/tasks
    public function store(Request $request)
    {
        $this->authorize('create', Task::class);

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'in:Pending,In Progress,Completed',
        ]);

        return Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status ?? 'Pending',
            'user_id' => $request->user()->id,
        ]);
    }

    // GET /api/tasks/{id}
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return $task;
    }

    // PUT /api/tasks/{id}
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'title' => 'sometimes|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'in:Pending,In Progress,Completed',
        ]);

        $task->update($request->only([
            'title',
            'description',
            'due_date',
            'status'
        ]));

        return $task;
    }

    // DELETE /api/tasks/{id}
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json([
            'message' => 'Deleted'
        ]);
    }
}