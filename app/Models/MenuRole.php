<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuRole extends Model
{
    protected $table = 'menu_roles';

    protected $fillable = [
        'menu_id',
        'role_id',
        'action_id',
        'is_active',
        'created_at'
    ];

    /**
     * Get the menu that owns the MenuRole
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    /**
     * Get the role that owns the MenuRole
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    /**
     * Get the action that owns the MenuRole
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id', 'id');
    }
}
