<?php

namespace App\Http\Controllers;

use App\Result;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Result $result) {
        $data = request()->validate([
            'body' => 'required',
            'rate' => 'required|integer'
        ]);
        $data['result_id'] = $result->id;
        $data['expert_id'] = $result->task->event->expert()->id;
        $review = Review::create($data);
        return redirect('/tasks/'.$result->task->id);
    }
    public function show(Review $review) {
        //  $task->load('users');
        return view('reviews.show', compact('review'));
    }
}
