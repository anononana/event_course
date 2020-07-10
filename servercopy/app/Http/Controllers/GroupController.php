<?php

namespace App\Http\Controllers;

use App\Event;
use App\Group;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Event $event) {
        $data = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'logo' => 'required|url',
        ]);
        $data['event_id'] = $event->id;
        $group = Group::create($data);
        $group->users()->syncWithoutDetaching(Auth::user());
        return redirect('/events/'.$event->id);
    }
    public function show(Group $group) {
            return view('groups.show', compact('group'));

    }
    public function storeParticipant (Group $group) {
        $data = request()->validate([
            'login' => ['required',
                Rule::in(User::select('login')->pluck('login')->toArray()),
            ]
        ]);
        $user = User::where('login', $data['login'])->first();
        if(!$group->event->isExpert($user)) {
            $group->users()->syncWithoutDetaching($user);
            return redirect('/groups/'.$group->id);
        } else {
            $v = Validator::make([], []);
            $v->after(function ($v) {
                $v->errors()->add('login', 'Пользователь уже является участником');
            });
            return redirect('/groups/' . $group->id);
        }
    }
}
