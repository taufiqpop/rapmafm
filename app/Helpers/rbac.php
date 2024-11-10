<?php

use App\Models\MenuRole;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;

if (!function_exists('rbacCheck')) {
    function rbacCheck($slug, $action_id)
    {
        $role_id = session('role_id');
        $check = MenuRole::where([
            'is_active' => 1,
            'role_id' => $role_id,
            // 'menu_id' => $menu_id,
            'action_id' => $action_id,
        ])->whereHas('menu', function ($query) use ($slug) {
            $query->where('slug_name', $slug);
        })->first();

        if (empty($check)) {
            return false;
        }

        return true;
    }
}
