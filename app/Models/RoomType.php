<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    public function getRoomType()
    {
    	return $this->hasMany('App\Models\RatePlan','room_type_id');
    }
}
