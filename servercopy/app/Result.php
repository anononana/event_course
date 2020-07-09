<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['group_id', 'task_id', 'answer', 'link', 'confirmed'];
    public function task() {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
    public function group() {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
    public function reviews() {
        return $this->hasMany(Review::class, 'result_id', 'id');
    }
    public function path() {
        return url('/results/'. $this->id);
    }
    public function isExpertReviewed() {
        return Review::where([['result_id', $this->id], ['expert_id', $this->task->event->expert()->id]])->exists();
    }
    public function expertReview() {
        return Review::where([['result_id', $this->id], ['expert_id', $this->task->event->expert()->id]])->first();
    }
}
