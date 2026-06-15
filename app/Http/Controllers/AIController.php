<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AIService;
use App\Models\Task;

class AIController extends Controller
{
    /**
     * CHAT endpoint
     */
    public function chat(Request $request, AIService $ai)
{
    $user = $request->user();

    $data = $ai->parseAdvancedCommand($request->message);

    // CREATE TASK
    if ($data['action'] === 'create') {
        $task = Task::create([
            'title' => $data['title'],
            'due_date' => $data['due_date'],
            'status' => 'Pending',
            'user_id' => $user->id,
        ]);

        return response()->json([
            'type' => 'task_created',
            'task' => $task
        ]);
    }

    // UPDATE TASK (SAFE)
    if ($data['action'] === 'update') {

        $task = Task::findOrFail($data['task_id']);

        // 🔒 IMPORTANT: POLICY CHECK
        $this->authorize('update', $task);

        $task->update([
            'status' => $data['status']
        ]);

        return response()->json([
            'type' => 'task_updated',
            'task' => $task
        ]);
    }

    // DELETE TASK (SAFE)
    if ($data['action'] === 'delete') {

        $task = Task::findOrFail($data['task_id']);

        // 🔒 POLICY ENFORCED
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json([
            'type' => 'task_deleted',
            'message' => 'Task deleted successfully'
        ]);
    }

    // fallback AI
    return response()->json(
        $ai->chat($request->message)
    );
}

    /**
     * TASK SUGGESTIONS
     */
    public function suggest(Request $request, AIService $ai)
    {
        $request->validate([
            'prompt' => 'required|string'
        ]);

        return response()->json([
            'suggestions' => $ai->suggest($request->prompt)
        ]);
    }

    /**
     * SUMMARIZATION
     */
    public function summarize(Request $request, AIService $ai)
    {
        $request->validate([
            'text' => 'required|string'
        ]);

        return response()->json([
            'summary' => $ai->summarize($request->text)
        ]);
    }

    /**
     * NATURAL LANGUAGE TASK COMMAND
     */
    public function command(Request $request, AIService $ai)
    {
        $user = $request->user();

        $data = $ai->parseCommand($request->message);

        // CREATE TASK
        if ($data['action'] === 'create') {
            $task = Task::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'due_date' => $data['due_date'],
                'status' => 'Pending',
                'user_id' => $user->id
            ]);

            return response()->json([
                'message' => 'Task created via AI',
                'task' => $task
            ]);
        }

        // LIST TASKS
        if ($data['action'] === 'list') {
            return response()->json([
                'tasks' => Task::where('user_id', $user->id)->get()
            ]);
        }

        return response()->json($data);
    }
}