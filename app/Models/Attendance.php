<?php

namespace App\Models;

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

    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }

    protected function startTime(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strlen($value) > 5 ? substr($value, 0, -3) : $value,
        );
    }

    protected function batasStartTime(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strlen($value) > 5 ? substr($value, 0, -3) : $value,
        );
    }

    protected function endTime(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strlen($value) > 5 ? substr($value, 0, -3) : $value,
        );
    }

    protected function batasEndTime(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strlen($value) > 5 ? substr($value, 0, -3) : $value,
        );
    }
}
