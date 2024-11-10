<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Terminologi extends Model
{
    use SoftDeletes;

    protected $table = 'terminologi';
    protected $guarded = ['id'];
}
