<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Controllers\Controller;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'title' => 'required',
            'task' => 'required',
            'right_answer' => '',
            'rate' => '',
            'event_id' => 'required', //если будет время - добавить картинку (файл).
            'link' => 'active_url'
        ]);

        $task = Task::create($data);
        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return Task
     */
    public function show(Task $task)
    {
        $task->event;
        return $task; //Можно ли при создании задания вводить не вручную event_id а достать его? Или это делается в интерфейсе
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Task $task)
    {
        $data = request()->validate([
            'title' => '',
            'task' => '',
            'right_answer' => '',
            'rate' => '',
            'event_id' => '',
            'link' => 'active_url'
        ]);

        $task->update($data);
        return response()->json($task, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
}
