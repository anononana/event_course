<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['body', 'rate', 'result_id', 'expert_id'];
    public function result() {
        return $this->belongsTo(Result::class, 'result_id', 'id');
    }
    public function expert() {
        return $this->belongsTo(Expert::class, 'expert_id', 'id');
    }
}
