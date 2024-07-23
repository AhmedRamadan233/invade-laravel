<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();
        $tasks = Task::with('categories')->filter($filters)->paginate(5);
        $categories = Category::with('tasks')->get();

        // dd($tasks);
        if ($request->wantsJson() || $request->query('api') == 'true') {
            return response()->json(['data' => $tasks], 200);
        } else {
            return view('pages.tasks.index', compact('tasks', 'categories'));
        }
    }
    public function store(StoreTaskRequest $request)
    {
        $validatedData = $request->validated();

        $task = Task::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
        ]);

        $task->categories()->sync($validatedData['categories']);

        return response()->json(['success' => true, 'message' => 'Task created successfully.', 'data' => $task], 201);
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

        $task->categories()->sync($validatedData['categories']);

        return response()->json(['success' => true, 'message' => 'Task updated successfully.', 'data' => $task], 200);
    }
    public function destroy(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully and moved to trash',
        ]);
    }

    public function getTasksTrashing(Request $request)
    {
        $filters = $request->query();
        $tasks = Task::onlyTrashed()->filter($filters)->paginate(5);

        if ($request->wantsJson() || $request->query('api') == 'true') {
            return response()->json(['data' => $tasks], 200);
        } else {
            return view('pages.tasks.trash', compact('tasks'));
        }
    }

    public function getTasksRestoring(Request $request, $id)
    {
        $task = Task::onlyTrashed()->findOrFail($id);
        $task->restore();

        return response()->json([
            'success' => true,
            'message' => 'Restored task with ID: ' . $id,
            'name' => $task->title,
        ]);
    }

    public function deleteTasksForced($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Force deleted task with ID: ' . $id,
            'name' => $task->title,
        ]);
    }
}
