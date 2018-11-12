<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class members extends Model
{
    protected $table = 'members';
    protected $fillable = ['name'];

    public function dates()
    {
        return $this->hasMany('App\Dates', 'member_id');
    }
}
