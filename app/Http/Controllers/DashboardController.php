<?php

namespace App\Http\Controllers;

use App\Models\Members;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Index
    public function index(Request $request)
    {
        $crew = Members::where('rank', 'Crew')->where('is_active', 1)->get();
        $pengurus = Members::where('rank', 'Pengurus')->where('is_active', 1)->get();
        $alumni = Members::where('rank', 'Alumni')->get();

        $data = [
            'title' => 'Beranda',
            'crew' => $crew,
            'pengurus' => $pengurus,
            'alumni' => $alumni,
        ];

        return view('contents.administrator.dashboard.home', $data);
    }
}
