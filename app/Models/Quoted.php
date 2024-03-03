<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Quoted extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'quoteds';
    protected $dates = ['deleted_at'];
    protected $casts = [
        'prices' => 'json',
    ];
}
