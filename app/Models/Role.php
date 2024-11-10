<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'type',
        'is_active',
        'slug_name'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];
}
