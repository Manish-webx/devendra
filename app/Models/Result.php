<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'result_date' => 'date',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
