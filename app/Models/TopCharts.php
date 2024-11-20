<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopCharts extends Model
{
    use SoftDeletes;

    protected $table = 'top_charts';
    protected $guarded = ['id'];
}
