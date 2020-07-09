<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $fillable = ['name', 'logo', 'description', 'event_id'];
    public function users() {
        return $this->belongsToMany(User::class, 'participants', 'group_id', 'user_id');
    }
    public function event() {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
    public function results() {
        return $this->hasMany(Result::class, 'group_id', 'id');
    }
   public function path()
   {
       return url('/groups/' . $this->id);
   }
}
