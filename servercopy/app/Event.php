<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    protected $fillable = ['title', 'description', 'place', 'scale', 'dt', 'dt_exp', 'finished'];
    //
    /**
     * @var mixed
     */
    private $tasks;
    public function path()
    {
        return url('/events/'. $this->id);
    }
    public function tasks() {
        return $this->hasMany(\App\Task::class, 'event_id', 'id');
    }
    public function groups() {
        return $this->hasMany(\App\Group::class, 'event_id', 'id');
    }
    public function users() {
        return $this->belongsToMany(\App\User::class, 'experts', 'event_id', 'user_id');
    }
    public function usersId() {
        return $this->belongsToMany(\App\User::class, 'experts', 'event_id', 'user_id')->select('users.id');
    }
    public function expert() {
      return  Expert::where([['event_id', $this->id], ['user_id', Auth::user()->id]])->first();
    }
    public function isUserExpert() {
        return (Auth::user()->admin || in_array(Auth::user()->id, Expert::where('event_id', $this->id)->pluck('user_id')->toArray()));
    }
    public function isExpert(User $user) {
        return ($user->admin || in_array($user->id, Expert::where('event_id', $this->id)->pluck('user_id')->toArray()));
    }
    public function isUserParticipant () {
       $groups = $this->groups;
       foreach ($groups as $group) {

           if (in_array(Auth::user()->id, Participant::where('group_id', $group->id)->pluck('user_id')->toArray())) {
               return true;
           }
       }
       return false;
    }
    public function isParticipant (User $user) {
        $groups = $this->groups;
        foreach ($groups as $group) {

            if (in_array($user->id, Participant::where('group_id', $group->id)->pluck('user_id')->toArray())) {
                return true;
            }
        }
        return false;
    }
    public function group() {
        return (Group::join('participants', 'participants.group_id', 'groups.id')->where([['participants.user_id', Auth::user()->id],['event_id', $this->id]])->select('groups.*')->first());
    }

    public function overallResults () {
        $sum = 0;
        $score = 0;
        $groups = $this->groups;
        foreach ($groups as $group) {
            foreach ($group->results as $result) {
                foreach ($result->reviews as $review) {
                    $sum += $review->rate;
                }
                $total = $sum / count($result->reviews);
                $result['total'] = $total;
                $sum = 0;
                $score += $result['total'];
            }
            $group['total'] = $score;
            $score = 0;
        }
        $array = $groups->toArray();

        usort($array,function($first,$second){
            return $first['total'] < $second['total'];
        });
       return $array ;
    }
}
