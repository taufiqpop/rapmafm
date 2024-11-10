<?php

namespace App\Http\Controllers;

use App\Models\MateriMatpel;
use App\Models\TerminologiHasUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerumusanController extends Controller
{
    // Perumusan Page
    public function index()
    {
        $user = Auth::user();
        $terminologi = TerminologiHasUser::where('user_id', $user->id)->with(['user', 'terminologi'])->get();

        $data = [
            'title' => 'Perumusan Tujuan & Kriteria Sukses',
            'terminologi' => $terminologi,
        ];

        return view('contents.perumusan.list', $data);
    }

    // Update Status Terminologi
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:terminologi_has_user,id',
            'status' => 'required|boolean',
        ]);

        try {
            $terminologi = TerminologiHasUser::findOrFail($request->id);
            $terminologi->status = $request->status;

            if ($terminologi->isDirty()) {
                $terminologi->save();
            }

            if ($terminologi->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Load Halaman
    public function load_halaman(Request $request)
    {
        $halaman = $request->halaman;
        $materi_matpel = MateriMatpel::all();

        $data = [
            'materi_matpel' => $materi_matpel,
        ];

        $html = view("contents.perumusan.halaman.{$halaman}", $data)->render();

        return response()->json([
            'status' => true,
            'html' => $html
        ]);
    }
}
