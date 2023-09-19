<?php

// app/Http/Controllers/TodoListController.php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TodoListController extends Controller
{
    public function create()
    {
        return view('todo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string|max:255',
            'deadline' => 'required|date',
        ]);

        try {
            TodoList::create($request->only(['task', 'deadline']));

            return redirect()->route('home')->with('success', 'To-Do List created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Failed to create To-Do List. Please try again later.');
        }
    }

    public function edit(TodoList $todoList)
    {
        return view('todo.edit', compact('todoList'));
    }

    public function update(Request $request, TodoList $todoList)
    {
        $request->validate([
            'task' => 'required|string|max:255',
            'deadline' => 'required|date',
        ]);

        try {
            $todoList->update($request->only(['task', 'deadline']));

            return redirect()->route('home')->with('success', 'To-Do List updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Failed to update To-Do List. Please try again later.');
        }
    }

    public function destroy(TodoList $todoList)
    {
        try {
            $todoList->delete();

            return redirect()->route('home')->with('success', 'To-Do List deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Failed to delete To-Do List. Please try again later.');
        }
    }
}

