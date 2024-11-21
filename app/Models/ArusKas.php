<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArusKas extends Model
{
    use SoftDeletes;

    protected $table = 'arus_kas';
    protected $guarded = ['id'];
}
