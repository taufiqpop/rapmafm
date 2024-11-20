<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\Events;
use App\Models\Settings;
use App\Models\TopCharts;
use App\Models\RapmaNews;
use App\Models\ProgramSiar;
use App\Models\Achievements;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        $settings = Settings::with(['program_siar'])->first();
        $structure = StrukturOrganisasi::where('is_active', 1)->get();
        $program = ProgramSiar::where('is_active', 1)->with(['program_siar.jenis_program'])->get();
        $events = Events::where('is_active', 1)->orderBy('order', 'asc')->get();
        $topcharts = TopCharts::all();
        $achievements = Achievements::where('is_active', 1)->get();
        $rapmanews = RapmaNews::where('is_active', 1)->get();

        $data = [
            'title' => 'Rapma FM',
            'settings' => $settings,
            'structure' => $structure,
            'program' => $program,
            'events' => $events,
            'topcharts' => $topcharts,
            'achievements' => $achievements,
            'rapmanews' => $rapmanews,
        ];

        return view('front.index', $data);
    }

    // Send Message
    public function send(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|string',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        try {
            $data = [
                'nama' => $request->nama,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ];

            Pesan::create($data);

            return response()->json(['status' => true, 'message' => 'Pesan berhasil dikirim.'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Terjadi kesalahan saat mengirim pesan.'], 400);
        }
    }
}
