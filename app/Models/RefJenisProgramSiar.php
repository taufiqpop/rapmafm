<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RefJenisProgramSiar extends Model
{
    use SoftDeletes;

    protected $table = 'ref_jenis_program_siar';
    protected $guarded = ['id'];

    public function jenis_program()
    {
        return $this->hasMany(RefProgramSiar::class, 'jenis_program_id', 'id');
    }
}
