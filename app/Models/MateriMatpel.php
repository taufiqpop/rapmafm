<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MateriMatpel extends Model
{
    use SoftDeletes;

    protected $table = 'ref_materi_matpel';
    protected $guarded = ['id'];

    public function matesekolah_has_materiri_matpel()
    {
        return $this->hasMany(SekolahHasMateri::class, 'id');
    }
}
