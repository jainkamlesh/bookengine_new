<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function getService()
    {
        return $this->hasMany('App\Models\Service','id');
    }
}
