<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RefSubDivisi extends Model
{
    use SoftDeletes;

    protected $table = 'ref_sub_divisi';
    protected $guarded = ['id'];

    public function divisi()
    {
        return $this->belongsTo(RefDivisi::class, 'divisi_id', 'id');
    }
}
