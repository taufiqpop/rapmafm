<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\ProgramSiar;
use App\Models\Settings;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        $settings = Settings::first();
        $structure = StrukturOrganisasi::where('is_active', 1)->get();
        $program = ProgramSiar::where('is_active', 1)->with(['program_siar.jenis_program'])->get();
        $events = Events::where('is_active', 1)->orderBy('order', 'asc')->get();

        $data = [
            'title' => 'Rapma FM',
            'settings' => $settings,
            'structure' => $structure,
            'program' => $program,
            'events' => $events,
        ];

        return view('front.index', $data);
    }
}
