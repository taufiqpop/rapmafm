<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SekolahHasMateri extends Model
{
    use SoftDeletes;

    protected $table = 'sekolah_has_materi';
    protected $guarded = ['id'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'id');
    }

    public function materi_matpel()
    {
        return $this->belongsTo(MateriMatpel::class, 'materi_matpel_id', 'id');
    }
}
