<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = ['deleted_at']; 

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    

    public function notes() {
        return $this->morphMany(Note::class, 'noteable');
    }

}
