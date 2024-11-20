<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RapmaNews extends Model
{
    use SoftDeletes;

    protected $table = 'rapma_news';
    protected $guarded = ['id'];
}
