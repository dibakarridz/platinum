<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    use HasFactory;
    protected $appends = ['file_url'];
    protected $table = 'settings';

    public function getFileURLAttribute() {
        
        return $this->attributes['file_url'] = $this->file_path ? asset('storage/'.$this->file_path) : null;
        
    }
}
