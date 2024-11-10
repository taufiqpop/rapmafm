<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class TerminologiHasUser extends Model
{
    use SoftDeletes;

    protected $table = 'terminologi_has_user';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function terminologi()
    {
        return $this->belongsTo(Terminologi::class, 'terminologi_id');
    }
}
