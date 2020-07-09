<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = [
        'title', 'task', 'link', 'right_answer', 'rate', 'event_id'
    ];
    /**
     * @var mixed
     */
    //private $event;
    public function getGroupResult () {
        return (Result::where([['task_id', $this->id],['group_id', $this->event->group()->id]])->first());
}
public function path() {
    return url('/tasks/'. $this->id);
}
    public function event() {
        return $this->belongsTo(\App\Event::class, 'event_id', 'id');
    }
    public function results() {
        return $this->hasMany(Result::class, 'task_id', 'id');
    }
}
