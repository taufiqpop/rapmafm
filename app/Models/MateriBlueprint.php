<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MateriBlueprint extends Model
{
    use SoftDeletes;

    protected $table = 'materi_blueprint';
    protected $guarded = ['id'];

    public function blueprint()
    {
        return $this->belongsTo(Blueprint::class, 'blueprint_id');
    }

    public function indikator()
    {
        return $this->hasMany(IndikatorBlueprint::class, 'materi_blueprint_id');
    }
}
