<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Query extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'queries';
    protected $dates = ['deleted_at'];

    public function booking() {
        return $this->hasOne(Booking::class);
    }

    public function quoted() {
        return $this->hasMany(Quoted::class);
    }

    public function forward() {
        return $this->hasMany(Forward::class);
    }
}
