<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemancarKondisiSuara extends Model
{
    use SoftDeletes;

    protected $table = 'pemancar_kondisi_suara';
    protected $guarded = ['id'];

    public function pemancar()
    {
        return $this->belongsTo(Pemancar::class, 'pemancar_id', 'id');
    }
}
