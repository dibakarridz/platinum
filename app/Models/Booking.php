<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Booking extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'bookings';
    protected $dates = ['deleted_at'];
}
