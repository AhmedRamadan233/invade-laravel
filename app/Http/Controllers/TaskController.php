<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::paginate(5);
        return view('pages.tasks.index', compact('tasks'));
    }
    public function store(StoreTaskRequest $request)
    {
        $validatedData = $request->validated();
        $defaultValues = [
            'title' => '',
            'description' => '',
            'status' => 'pending',
        ];

        $validatedData = array_merge($defaultValues, $validatedData);

        $task = Task::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
        ]);

        if ($task) {
            return response()->json(['success' => true, 'message' => 'task created successfully.'], 201);
        }

        return response()->json(['success' => false, 'message' => 'task creation failed.'], 500);
    }
    public function toggleStatus(Request $request, $id)
    {

        $task = Task::findOrFail($id);

        $task->status = ($task->status === 'pending') ? 'completed' : 'pending';
        $task->save();

        return response()->json(['status' => $task->status]);
    }
    public function editTask($id)
    {
        $editTask = Task::findOrFail($id);
        return response()->json(['editTask' => $editTask]);
    }

    public function update(UpdateTaskRequest $request)
    {
        $validatedData = $request->validated();
        $id = $request->input('id');
        $task = Task::findOrFail($id);

        $task->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
        ]);

        return response()->json(['success' => true, 'message' => 'Task updated successfully.'], 200);
    }

    public function destroy(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->delete();

        if ($task) {
            return response()->json(['success' => true, 'message' => 'Task and image deleted successfully']);
        } else {
            return response()->json(['success' => true, 'message' => 'Task deleted successfully, but image not found or already deleted']);
        }
    }
}
