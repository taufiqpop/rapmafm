<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use SoftDeletes;
    protected $table = 'menus';

    protected $fillable = [
        'parent_id',
        'name',
        'slug_name',
        'order',
        'link',
        'icon',
        'is_active',
        'created_at',
    ];

    /**
     * The roles that belong to the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'menu_roles', 'menu_id', 'role_id');
    }

    /**
     * Get all of the permission for the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasOne(MenuRole::class, 'menu_id', 'id');
    }

    /**
     * Get the parent that owns the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }
}
