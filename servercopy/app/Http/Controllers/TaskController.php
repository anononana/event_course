<?php

namespace App\Http\Controllers;

use App\Event;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $data = Task::all();
        return view('tasks.view', compact('data'));
    }
    public function create() {
        return view('tasks.create');
    }
    public function destroy(\App\Task $task) {
        $task->delete();
        return redirect('/tasks');
    }
    public function edit(\App\Task $task) {
        return view('tasks.edit', compact('task'));
    }
    public function update(\App\Task $task) {
        $data = request()->validate([
            'title' => 'required',
            'rate' => 'required|integer',
            'task' => 'required',
            'link' => 'nullable|url',
            'right_answer' => 'nullable'
        ]);
        $task->update($data);
        return redirect('/tasks/'.$task->id);
    }
    public function store(Event $event) {
        $data = request()->validate([
            'title' => 'required',
            'rate' => 'required|integer',
            'task' => 'required',
            'link' => 'nullable|url',
            'right_answer' => 'nullable'
        ]);
        $data['event_id'] = $event->id;
        //   $task = auth()->user()->tasks()->create($data);
        $task = Task::create($data);
        return redirect('/events/'.$event->id);
    }

    public function show(Task $task) {
        //  $task->load('users');
        return view('tasks.show', compact('task'));
    }
}
