<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Beranda'
        ];

        return view('contents.dashboard.home', $data);
    }
}
