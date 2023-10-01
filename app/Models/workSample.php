<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workSample extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function file(){
        return $this->morphOne(File::class , 'fileable');
    }

    public function files(){
        return $this->morphMany(File::class , 'fileable');
    }
}
