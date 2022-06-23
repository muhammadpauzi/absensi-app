<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'batas_start_time',
        'end_time',
        'batas_end_time',
        'code'
    ];

    protected $appends = ['data'];

    protected function data(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                // now()->timestamp()
                $startTimestamp = strtotime($this->start_time);
                $batasStartTimestamp = strtotime($this->batas_start_time);

                $endTimestamp = strtotime($this->end_time);
                $batasEndTimestamp = strtotime($this->batas_end_time);

                $nowTimestamp = strtotime(now()->format("H:i:s"));

                return (object) [
                    "start_time" => $this->start_time,
                    "batas_start_time" => $this->batas_start_time,
                    "now" => now()->format("H:i:s"),
                    "is_start" => $startTimestamp <= $nowTimestamp && $batasStartTimestamp >= $nowTimestamp,
                    "is_end" => $endTimestamp <= $nowTimestamp && $batasEndTimestamp >= $nowTimestamp
                ];
            },
        );
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }
}
