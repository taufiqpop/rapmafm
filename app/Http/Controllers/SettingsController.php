<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $settings = Settings::first();

        $data = [
            'title' => 'Settings',
            'settings' => $settings
        ];

        return view('contents.settings.index', $data);
    }
}
