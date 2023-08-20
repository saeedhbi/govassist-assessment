<?php

namespace Packages\URLShortener\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class URL extends Model
{
    protected $table = "urls";

    use HasFactory;

    protected $hidden = ['visits'];

    protected $fillable = [
        'destination',
        'slug',
        'visits',
    ];
}
