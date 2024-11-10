<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Sekolah extends Model
{
    use SoftDeletes;

    protected $table = 'sekolah';
    protected $guarded = ['id'];

    public function blueprint()
    {
        return $this->hasMany(Blueprint::class, 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function dokumentasi()
    {
        return $this->hasMany(Dokumentasi::class, 'id');
    }

    public function materi_pelajaran()
    {
        return $this->hasMany(SekolahHasMateri::class, 'sekolah_id');
    }
}
