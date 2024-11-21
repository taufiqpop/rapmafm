<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title' => 'Beranda'
        ];

        return view('contents.dashboard.home', $data);
    }
}
