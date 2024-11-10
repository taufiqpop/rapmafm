<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndikatorBlueprint extends Model
{
    use SoftDeletes;

    protected $table = 'indikator_blueprint';
    protected $guarded = ['id'];

    public function materi()
    {
        return $this->belongsTo(MateriBlueprint::class, 'materi_blueprint_id');
    }
}
