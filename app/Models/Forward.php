<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Forward extends Model
{
    use HasFactory, softDeletes;
    protected $table = 'forwards';
    protected $dates = ['deleted_at'];
}
