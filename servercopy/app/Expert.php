<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    public function reviews() {
        return $this->hasMany(Review::class, 'expert_id', 'id');
    }
    public function getCredentials () {
        return User::where('id', $this->user_id)->first();
    }
}
