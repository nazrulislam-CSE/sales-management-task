<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $guarded = [];
    public function noteable() {
        return $this->morphTo();
    }
}
