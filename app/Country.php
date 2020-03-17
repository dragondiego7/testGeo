<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['ip', 'mask', "num_start", "num_end", "initials", "name"];


}
