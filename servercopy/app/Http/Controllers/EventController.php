<?php

namespace App\Http\Controllers;

use App\Event;
use App\Expert;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
/*    public function __construct()
    {
        $this->middleware('auth');
    } */

    public function index() {
        $data = Event::orderBy('dt', 'DESC')->get();
        return view('events.view', compact('data'));
    }
    public function create() {
        return view('events.create');
    }
    public function destroy(\App\Event $event) {
        $event->delete();
        return redirect('/events');
    }
    public function edit(\App\Event $event) {
        return view('events.edit', compact('event'));
    }
    public function finish(Event $event) {
        $event->update(['finished'=>true]);
        return redirect('/events/'.$event->id);
    }
    public function update(\App\Event $event) {
        $data = request()->validate([
            'title' => 'string|required',
            'description' => 'string|required',
            'place' => 'string|required',
            'scale' => 'integer|required',
            'dt' => 'required|date',
            'dt_exp' => 'required|date|after:dt'
        ]);
        $event->update($data);
        return redirect('/events/'.$event->id);
    }
    public function store() {
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'place' => 'required',
            'scale' => 'required|integer',
            'dt' => 'required|date',
            'dt_exp' => 'required|date|after:dt'
        ]);
     //   $event = auth()->user()->events()->create($data);
        $event = Event::create($data);
        $event->users()->syncWithoutDetaching(Auth::user());
        return redirect('/events/'.$event->id);
    }
    public function storeExpert (Event $event) {

        $data = request()->validate([
            'login' => ['required',
                Rule::in(User::select('login')->pluck('login')->toArray()),
]
        ]);
        $user = User::where('login', $data['login'])->first();
        if(!$event->isParticipant($user)) {
            $event->users()->syncWithoutDetaching($user);
            return redirect('/events/'.$event->id);
        } else {
            $v = Validator::make([], []);
            $v->after(function ($v) {
                $v->errors()->add('login', 'Пользователь уже является участником');
            });
            return redirect('/events/' . $event->id);
        }
    }

    public function show(Event $event) {
      //  $event->load('users');
        return view('events.show', compact('event'));
    }
}
