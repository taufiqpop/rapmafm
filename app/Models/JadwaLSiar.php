<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalSiar extends Model
{
    use SoftDeletes;

    protected $table = 'jadwal_siar';
    protected $guarded = ['id'];
}
