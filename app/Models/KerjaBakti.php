<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KerjaBakti extends Model
{
    use SoftDeletes;

    protected $table = 'kerja_bakti';
    protected $guarded = ['id'];
}
