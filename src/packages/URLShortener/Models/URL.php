<?php

namespace Packages\URLShortener\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL as URLAlias;

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

    public function getShortenedUrlAttribute(): string
    {
        return URLAlias::to($this->slug);
    }
}
