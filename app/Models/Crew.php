<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Crew extends Model
{
    use SoftDeletes;

    protected $table = 'crew';
    protected $guarded = ['id'];
}
