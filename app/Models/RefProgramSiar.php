<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RefProgramSiar extends Model
{
    use SoftDeletes;

    protected $table = 'ref_program_siar';
    protected $guarded = ['id'];

    public function jenis_program()
    {
        return $this->belongsTo(RefJenisProgramSiar::class, 'jenis_program_id', 'id');
    }
}
