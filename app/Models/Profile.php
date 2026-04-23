<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'address',
    ];

    protected $casts = [
        'phone_number' => 'string',
        'address' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

