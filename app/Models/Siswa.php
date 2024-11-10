<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use SoftDeletes;

    protected $table = 'siswa';
    protected $guarded = ['id'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    public function blueprints()
    {
        return $this->hasMany(Blueprint::class, 'sekolah_id', 'sekolah_id');
    }
}
