<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    public function getSpecie()
   {
       return $this->belongsTo('App\Models\Specie', 'specie_id', 'id');
   }

   public function getAnimals()
    {
        return $this->hasMany('App\Models\Animal', 'manager_id', 'id');
    }

}
