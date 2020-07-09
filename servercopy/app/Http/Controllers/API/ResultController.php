<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Group;
use App\Http\Controllers\Controller;
use App\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Group::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'group_id' => 'required',
            'task_id' => 'required',
            'answer' => 'required',
            'link' => 'active_url'
        ]);

        $result = Result::create($data);
        return response()->json($result, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        $result->task;
        $result->group;
        $result->reviews;
        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Result $result)
    {
        $data = request()->validate([
            'group_id' => '',
            'task_id' => '',
            'answer' => '',
            'link' => 'active_url'
        ]);

        $result = Result::update($data);
        return response()->json($result, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        $result->delete();
        return response()->json(null,204);
    }
}
