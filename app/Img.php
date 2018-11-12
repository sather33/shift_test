<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Img extends Model
{
    protected $fillable = ['url', 'imgable_id', 'imgable_type', 'order', 'tag'];

	protected $table = 'imgs';

	public function imgable()
    {
        return $this->morphTo();
    }
}