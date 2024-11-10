<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokumentasi extends Model
{
    use SoftDeletes;

    protected $table = 'dokumentasi';
    protected $guarded = ['id'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }
}
