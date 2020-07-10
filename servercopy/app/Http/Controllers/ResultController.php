<?php

namespace App\Http\Controllers;

use App\Expert;
use App\Result;
use App\Review;
use App\Task;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Task $task) {
        $data = request()->validate([
            'answer' => 'required',
            'link' => 'nullable|url'
        ]);
        if(isset($task->right_answer) && $data['answer'] == $task->right_answer) {
            $review['rate'] = $task->rate;
            $review['body'] = 'Задание проверено автоматически';
        } else {
            $review['rate'] = 0;
            $review['body'] = 'Задание проверено автоматически';
        }
        $data['task_id'] = $task->id;
        $data['group_id'] = $task->event->group()->id;
        $result = Result::create($data);
        if(isset($task->right_answer)) {
            $review['result_id'] = $result->id;
            $review['expert_id'] = Expert::where('event_id', $task->event->id)->first()->id;
            Review::create($review);
        }
        return redirect('/tasks/'.$task->id);
    }
    public function show(Result $result) {
        //  $task->load('users');
        return view('results.show', compact('result'));
    }
}
