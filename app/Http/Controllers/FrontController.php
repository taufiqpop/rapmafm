<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        $settings = Settings::first();

        $data = [
            'title' => 'Rapma FM',
            'settings' => $settings
        ];

        return view('front.index', $data);
    }
}
