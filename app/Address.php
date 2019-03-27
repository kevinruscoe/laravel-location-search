<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use KevinRuscoe\Traits\PointParserTrait;

class Address extends Model
{
    use PointParserTrait;

    protected $fillable = [
        'location'
    ];
}
