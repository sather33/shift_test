<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $table = 'week';
    protected $fillable = ['name', 'range', 'shop_id'];

    public function dates()
    {
        return $this->hasMany('App\Dates', 'week_id');
    }
}
