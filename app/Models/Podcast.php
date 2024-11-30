<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Podcast extends Model
{
    use SoftDeletes;

    protected $table = 'podcast';
    protected $guarded = ['id'];

    public function program_siar()
    {
        return $this->belongsTo(RefProgramSiar::class, 'program_id', 'id');
    }
}
