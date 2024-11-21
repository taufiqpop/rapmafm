<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Crew;
use App\Models\Pengurus;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $crew = Crew::where('is_active', 1)->get();
        $pengurus = Pengurus::where('is_active', 1)->get();
        $alumni = Alumni::all();

        $data = [
            'title' => 'Beranda',
            'crew' => $crew,
            'pengurus' => $pengurus,
            'alumni' => $alumni,
            'crewCount' => $crew->count(),
            'pengurusCount' => $pengurus->count(),
            'alumniCount' => $alumni->count(),
        ];

        return view('contents.dashboard.home', $data);
    }
}
