<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        return view('tasks.index', [
            'tasks' => Task::latest()->get(),
            'stats' => [
                'total' => Task::count(),
                'pending' => Task::where('status', 'pending')->count(),
                'completed' => Task::where('status', 'completed')->count(),
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Task::create($this->validated($request));

        return $this->dashboardRedirect('Task added to your list.');
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $task->update($this->validated($request));

        return $this->dashboardRedirect('Task updated successfully.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return $this->dashboardRedirect('Task removed from your list.');
    }

    public function toggle(Task $task): RedirectResponse
    {
        $task->update([
            'status' => $task->status === 'completed' ? 'pending' : 'completed',
        ]);

        return $this->dashboardRedirect('Task status updated.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:pending,completed'],
            'due_date' => ['nullable', 'date'],
        ]);
    }

    private function dashboardRedirect(string $message): RedirectResponse
    {
        session()->flash('success', $message);
        $response = new RedirectResponse('/');

        return $response;
    }
}