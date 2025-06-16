<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\Task;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'item' => 'required|string|max:255'
        ]);

        $task->checklists()->create([
            'item_name' => $validated['item'], 
            'task_id' => $task->id, 
            'completed' => false
        ]);

        return back()->with('success', 'Item añadido al checklist');
    }

    public function update(Request $request, Checklist $checklist)
    {
        $checklist->update(['completed' => !$checklist->completed]);
        return back();
    }

    public function destroy(Checklist $checklist)
    {
        $checklist->delete();
        return back()->with('success', 'Item eliminado');
    }
}
