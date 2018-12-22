<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class members extends Model
{
    protected $table = 'members';
    protected $fillable = ['name', 'actived'];

    public function dates()
    {
        return $this->hasMany('App\Dates', 'member_id');
    }

    public function scopeActived($query)
    {
        return $query->where('actived', true);
    }

    public function scopeUnactived($query)
    {
        return $query->where('actived', false);
    }
}
