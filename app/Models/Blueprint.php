<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blueprint extends Model
{
    use SoftDeletes;

    protected $table = 'blueprint';
    protected $guarded = ['id'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    public function materi()
    {
        return $this->hasMany(MateriBlueprint::class, 'blueprint_id');
    }
}
