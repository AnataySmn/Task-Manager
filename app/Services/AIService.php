<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Task;

class AIService
{
    /**
     * CHAT (Hybrid OpenAI + Fallback)
     */
    public function chat(string $message): array
{
    try {
        $response = OpenAI::client(env('OPENAI_API_KEY'))->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a helpful task management assistant.'
                ],
                [
                    'role' => 'user',
                    'content' => $message
                ]
            ]
        ]);

        return [
            'type' => 'ai',
            'data' => [
                'message' => $response->choices[0]->message->content
            ]
        ];

    } catch (\Exception $e) {
        return $this->fallback($message);
    }
}
    /**
     * TASK SUGGESTIONS
     */
    public function suggest(string $prompt): array
    {
        return [
            "Break your task into small steps",
            "Set a clear deadline",
            "Focus on high priority items first",
            "Review progress daily",
            "Avoid multitasking"
        ];
    }

    /**
     * SUMMARIZATION
     */
    public function summarize(string $text): string
    {
        return "Summary: " . substr($text, 0, 120) . "...";
    }

    /**
     * NATURAL LANGUAGE PARSER
     */
    public function parseCommand(string $message): array
    {
        $msg = strtolower($message);

        // CREATE TASK
        if (str_contains($msg, 'create') || str_contains($msg, 'add')) {
            return [
                'action' => 'create',
                'title' => $this->extractTitle($message),
                'description' => $message,
                'due_date' => now()->addDay()->toDateString()
            ];
        }

        // LIST TASKS
        if (str_contains($msg, 'list')) {
            return [
                'action' => 'list'
            ];
        }

        // DELETE TASK
        if (str_contains($msg, 'delete')) {
            return [
                'action' => 'delete'
            ];
        }

        return [
            'action' => 'unknown',
            'message' => 'I could not understand the command.'
        ];
    }

    /**
     * FALLBACK RESPONSE
     */
    private function fallback(string $message): array
{
    $msg = strtolower($message);

    // CREATE TASK
    if (str_contains($msg, 'create') || str_contains($msg, 'add')) {
        return [
            'type' => 'task_suggestion',
            'data' => [
                'title' => $this->extractTitle($message),
                'priority' => 'high',
                'due_date' => 'tomorrow',
                'steps' => [
                    'Break task into small parts',
                    'Implement step by step',
                    'Test functionality',
                    'Review and improve'
                ]
            ]
        ];
    }

    // LIST TASKS
    if (str_contains($msg, 'list')) {
        return [
            'type' => 'info',
            'data' => [
                'message' => 'Use GET /api/tasks to view your tasks',
                'filter' => 'You can filter by status or date'
            ]
        ];
    }

    // DELETE TASK
    if (str_contains($msg, 'delete')) {
        return [
            'type' => 'warning',
            'data' => [
                'message' => 'Ensure you own the task before deleting',
                'endpoint' => 'DELETE /api/tasks/{id}'
            ]
        ];
    }

    // DEFAULT
    return [
        'type' => 'general',
        'data' => [
            'message' => 'Break your work into small tasks and prioritize them'
        ]
    ];
}
    /**
     * Extract simple title
     */
    private function extractTitle(string $message): string
{
    $title = str_ireplace(['create', 'add', 'task'], '', $message);

    return trim(preg_replace('/\b(to|a|an|for)\b/i', '', $title));
}

public function parseAndBuildTask(string $message): ?array
{
    $msg = strtolower($message);

    if (str_contains($msg, 'create') || str_contains($msg, 'add')) {
        return [
            'title' => $this->extractTitle($message),
            'due_date' => $this->extractDueDate($message),
            'description' => $message,
            'status' => 'Pending'
        ];
    }

    return null;
}

private function extractDueDate(string $message): string
{
    $msg = strtolower($message);

    if (str_contains($msg, 'tomorrow')) {
        return now()->addDay()->toDateString();
    }

    if (str_contains($msg, 'today')) {
        return now()->toDateString();
    }

    if (str_contains($msg, 'friday')) {
        return now()->next('Friday')->toDateString();
    }

    return now()->addDays(2)->toDateString();
}

public function parseAdvancedCommand(string $message): array
{
    $msg = strtolower($message);

    // CREATE
    if (str_contains($msg, 'create') || str_contains($msg, 'add')) {
        return [
            'action' => 'create',
            'title' => $this->extractTitle($message),
            'due_date' => $this->extractDueDate($message),
        ];
    }

    // UPDATE
    if (str_contains($msg, 'update') || str_contains($msg, 'change')) {
        return [
            'action' => 'update',
            'task_id' => $this->extractId($message),
            'status' => $this->extractStatus($message),
        ];
    }

    // DELETE
    if (str_contains($msg, 'delete') || str_contains($msg, 'remove')) {
        return [
            'action' => 'delete',
            'task_id' => $this->extractId($message),
        ];
    }

    return [
        'action' => 'unknown'
    ];
}

private function extractId(string $message): ?int
{
    preg_match('/\d+/', $message, $matches);
    return $matches[0] ?? null;
}

private function extractStatus(string $message): string
{
    if (str_contains(strtolower($message), 'completed')) {
        return 'Completed';
    }

    if (str_contains(strtolower($message), 'progress')) {
        return 'In Progress';
    }

    return 'Pending';
}
}