<?php

namespace Gyrobus\MoonshineSeo\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $fillable = [
        'path', 'title', 'description', 'image'
    ];
}
