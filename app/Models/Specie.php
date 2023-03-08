<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specie extends Model
{
    use HasFactory;

    public function getManagers()
    {
        return $this->hasMany('App\Models\Manager', 'specie_id', 'id');
    }

    public function getAnimals()
    {
        return $this->hasMany('App\Models\Animal', 'specie_id', 'id');
    }
 
 
}
