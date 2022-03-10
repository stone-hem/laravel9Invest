<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;


    public function createClientProjectRealtion()
    {
        return $this->hasOne(Clientproject::class,'entity_id','id');
    }
}
