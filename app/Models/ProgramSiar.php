<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramSiar extends Model
{
    use SoftDeletes;

    protected $table = 'program_siar';
    protected $guarded = ['id'];

    public function program_siar()
    {
        return $this->belongsTo(RefProgramSiar::class, 'program_id', 'id');
    }
}
