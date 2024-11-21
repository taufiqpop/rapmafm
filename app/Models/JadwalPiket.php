<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalPiket extends Model
{
    use SoftDeletes;

    protected $table = 'jadwal_piket';
    protected $guarded = ['id'];
}
