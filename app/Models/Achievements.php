<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achievements extends Model
{
    use SoftDeletes;

    protected $table = 'achievements';
    protected $guarded = ['id'];
}
