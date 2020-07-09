<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Event::orderBy('dt', 'DESC')->get();
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
            'title' => 'required',
            'place' => 'required',
            'dt' => 'required|date',
            'dt_exp' => 'required|date',
            'description' => 'required',
            'scale' => 'required'
        ]);

        $event = Event::create($data);
        return response()->json($event, 201);
    }
    public function storeExperts(Event $event, User $user) {
        $event->users()->syncWithoutDetaching($user);
        return [$event, $user];
    }

    /**
     * Display the specified resource.
     *
     * @param Event $event
     * @return Event
     */
    public function show(Event $event)
    {
        $event->tasks;
        $event->groups;
        return $event;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Event $event
     * @return JsonResponse
     */
    public function update(Request $request, Event $event)
    {
        $data = request()->validate([
            'title' => 'required',
            'place' => 'required',
            'dt' => 'date|required',
            'dt_exp' => 'date|required',
            'description' => 'required',
            'scale' => 'required'
        ]);

        $event ->update($data);
        return response()->json($event, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(null, 204);
    }
}
