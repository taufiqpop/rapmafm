<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventarisasi extends Model
{
    use SoftDeletes;

    protected $table = 'inventarisasi';
    protected $guarded = ['id'];
}
