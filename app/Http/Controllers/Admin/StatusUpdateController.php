<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatusUpdate;
use App\Models\Task;
use Illuminate\Http\Request;

class StatusUpdateController extends Controller
{
    /**
     * Store a new status update for a task.
     */
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $task->statusUpdates()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->route('admin.tasks.show', $task)
            ->with('success', 'Update posted.');
    }

    /**
     * Delete a specific status update.
     */
    public function destroy(Task $task, StatusUpdate $update)
    {
        abort_if($update->task_id !== $task->id, 404);

        $update->delete();

        return redirect()->route('admin.tasks.show', $task)
            ->with('success', 'Update deleted.');
    }
}