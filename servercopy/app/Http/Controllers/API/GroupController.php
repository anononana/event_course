<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => 'required',
            'logo' => 'active_url',
            'event_id' => 'required',
            'description' => 'required'
        ]);

        $group = Group::create($data);
        return response()->json($group, 201);
    }
    public function storePart(Group $group, User $user) {
            $group->users()->syncWithoutDetaching($user);
            return [$group, $user];

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $group->users;
        return $group;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = request()->validate([
            'name' => '',
            'logo' => 'active_url',
            'event_id' => '',
            'description' => ''
        ]);

        $group = Group::update($data);
        return response()->json($group, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Group $group
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return response()->json(null, 204);
    }
}
