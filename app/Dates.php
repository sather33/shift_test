<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dates extends Model
{
    protected $table = 'dates';
    protected $fillable = ['member_id', 'year', 'month', 'day', 'shift', 'week_id'];

    public function member()
    {
        return $this->belongsTo('App\members');
    }

    public function weekday()
    {
        return $this->belongsTo('App\Week', 'week_id');
    }

    public function scopeDates($query, $year, $month, $day)
    {
        return $query->where('year', $year)->where('month', $month)->where('day', $day)->orderBy('day', 'ASC');
    }
}
