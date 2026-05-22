<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TaskController extends Controller
{
    /**
     * Display a dashboard with statistics.
     */
    public function dashboard()
    {
        $taskCount = Task::count();
        $userCount = User::count();
        $roleCount = Role::count();
        $permissionCount = Permission::count();

        $tasksByStatus = [
            'pending' => Task::where('status', 'pending')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'completed' => Task::where('status', 'completed')->count(),
        ];

        $recentTasks = Task::with('assignedUser')->latest()->take(5)->get();

        return view('dashboard', compact('taskCount', 'userCount', 'roleCount', 'permissionCount', 'tasksByStatus', 'recentTasks'));
    }

    /**
     * Display a listing of tasks.
     */
    public function index()
    {
        // Spatie check via Gate or model policy
        if (!auth()->user()->can('view tasks')) {
            abort(403, 'No tienes permiso para ver las tareas.');
        }

        $tasks = Task::with('assignedUser')->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        if (!auth()->user()->can('create tasks')) {
            abort(403, 'No tienes permiso para crear tareas.');
        }

        $users = User::all();
        return view('tasks.create', compact('users'));
    }

    /**
     * Store a newly created task in database.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('create tasks')) {
            abort(403, 'No tienes permiso para crear tareas.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Tarea creada exitosamente.');
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task)
    {
        if (!auth()->user()->can('view tasks')) {
            abort(403, 'No tienes permiso para ver esta tarea.');
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        if (!auth()->user()->can('edit tasks')) {
            abort(403, 'No tienes permiso para editar tareas.');
        }

        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    /**
     * Update the specified task in database.
     */
    public function update(Request $request, Task $task)
    {
        if (!auth()->user()->can('edit tasks')) {
            abort(403, 'No tienes permiso para editar tareas.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada exitosamente.');
    }

    /**
     * Remove the specified task from database.
     */
    public function destroy(Task $task)
    {
        if (!auth()->user()->can('delete tasks')) {
            abort(403, 'No tienes permiso para eliminar tareas.');
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada exitosamente.');
    }
}
