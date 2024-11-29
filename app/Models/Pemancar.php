<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemancar extends Model
{
    use SoftDeletes;

    protected $table = 'pemancar';
    protected $guarded = ['id'];

    public function daerah()
    {
        return $this->hasMany(PemancarKondisiSuara::class, 'pemancar_id');
    }
}
