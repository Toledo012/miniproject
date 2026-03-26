<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    protected $fillable = [
        'about_us',
        'mission',
        'vision',
        'location',
        'contact',
    ];
}

