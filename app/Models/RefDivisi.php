<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RefDivisi extends Model
{
    use SoftDeletes;

    protected $table = 'ref_divisi';
    protected $guarded = ['id'];

    public function sub_divisi()
    {
        return $this->hasMany(RefSubDivisi::class, 'divisi_id', 'id');
    }
}
