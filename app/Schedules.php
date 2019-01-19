<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
    protected $table = 'schedules';
    protected $fillable = ['year', 'month', 'day', 'shift', 'week_id', 'actived'];

    public function weekday()
    {
        return $this->belongsTo('App\Week', 'week_id');
    }

    public function scopeDates($query, $year, $month, $day)
    {
        return $query->where('year', $year)->where('month', $month)->where('day', $day)->orderBy('day', 'ASC');
    }
}
