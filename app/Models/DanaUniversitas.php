<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DanaUniversitas extends Model
{
    use SoftDeletes;

    protected $table = 'dana_universitas';
    protected $guarded = ['id'];
}
