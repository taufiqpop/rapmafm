<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Blueprint;
use App\Models\SekolahHasMateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class SekolahController extends Controller
{
    // Data Non Arsip
    public function data(Request $request)
    {
        $user_id = Auth::id();
        $list = Sekolah::with(['materi_pelajaran.materi_matpel'])
            ->where('user_id', $user_id)
            ->where('is_archived', 0);

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('encrypted_id', function ($row) {
                return Crypt::encryptString($row->id);
            })
            ->addColumn('materi_pelajaran', function ($row) {
                return $row->materi_pelajaran->map(function ($item) {
                    return $item->materi_matpel->nama_materi;
                })->implode(', ');
            })
            ->make();
    }

    // Data Arsip
    public function dataArsip(Request $request)
    {
        $user_id = Auth::id();
        $list = Sekolah::with(['materi_pelajaran.materi_matpel'])
            ->where('user_id', $user_id)
            ->where('is_archived', 1);

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('encrypted_id', function ($row) {
                return Crypt::encryptString($row->id);
            })
            ->addColumn('materi_pelajaran', function ($row) {
                return $row->materi_pelajaran->map(function ($item) {
                    return $item->materi_matpel->nama_materi;
                })->implode(', ');
            })
            ->make();
    }

    // Store Kelas
    public function store(Request $request)
    {
        $user_id = Auth::id();

        $request->validate([
            'nama' => 'required|string',
            'tahun' => 'required|string',
            'matpel' => 'required|string',
            'semester' => 'required|string',
            'kelas' => 'required|string',
            'kode_kelas' => 'required|string',
            'nama_guru' => 'required|string',
            'materi_matpel_id' => 'required|array',
        ], [
            'nama.required' => 'Nama Sekolah Wajib Diisi',
            'tahun.required' => 'Tahun Wajib Diisi',
            'matpel.required' => 'Mata Pelajaran Wajib Diisi',
            'semester.required' => 'Semester Wajib Diisi',
            'kelas.required' => 'Kelas Wajib Diisi',
            'kode_kelas.required' => 'Kode Kelas Wajib Diisi',
            'nama_guru.required' => 'Nama Guru Wajib Diisi',
            'materi_matpel_id.required' => 'Materi Matpel Wajib Diisi',
        ]);

        try {
            $data = [
                'user_id' => $user_id,
                'nama' => $request->nama,
                'tahun' => $request->tahun,
                'matpel' => $request->matpel,
                'semester' => $request->semester,
                'kelas' => $request->kelas,
                'kode_kelas' => $request->kode_kelas,
                'nama_guru' => $request->nama_guru,
            ];

            $sekolah = Sekolah::create($data);
            $static_values = ['Kognitif', 'Afektif', 'Psikomotorik'];

            foreach ($static_values as $value) {
                $instrumen_penilaian = ($value == 'Kognitif') ? 'Tes' : 'Non Tes';
                $bluerpint = [
                    'sekolah_id' => $sekolah->id,
                    'ranah_penilaian' => $value,
                    'instrumen_penilaian' => $instrumen_penilaian,
                ];

                Blueprint::create($bluerpint);
            }

            $materi_matpel_ids = $request->materi_matpel_id;
            foreach ($materi_matpel_ids as $materi_matpel_id) {
                SekolahHasMateri::create([
                    'sekolah_id' => $sekolah->id,
                    'materi_matpel_id' => $materi_matpel_id,
                ]);
            }

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update Kelas
    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'tahun' => 'required|string',
            'matpel' => 'required|string',
            'semester' => 'required|string',
            'kelas' => 'required|string',
            'kode_kelas' => 'required|string',
            'nama_guru' => 'required|string',
            'materi_matpel_id' => 'required|array',
        ], [
            'nama.required' => 'Nama Sekolah Wajib Diisi',
            'tahun.required' => 'Tahun Wajib Diisi',
            'matpel.required' => 'Mata Pelajaran Wajib Diisi',
            'semester.required' => 'Semester Wajib Diisi',
            'kelas.required' => 'Kelas Wajib Diisi',
            'kode_kelas.required' => 'Kode Kelas Wajib Diisi',
            'nama_guru.required' => 'Nama Guru Wajib Diisi',
            'materi_matpel_id.required' => 'Materi Matpel Wajib Diisi',
        ]);

        try {
            $sekolah = Sekolah::findOrFail($request->id);
            $sekolah->nama = $request->nama;
            $sekolah->tahun = $request->tahun;
            $sekolah->matpel = $request->matpel;
            $sekolah->semester = $request->semester;
            $sekolah->kelas = $request->kelas;
            $sekolah->kode_kelas = $request->kode_kelas;
            $sekolah->nama_guru = $request->nama_guru;

            if ($sekolah->isDirty()) {
                $sekolah->save();
            }

            $materi_matpel_ids = $request->materi_matpel_id;

            SekolahHasMateri::where('sekolah_id', $sekolah->id)->delete();

            foreach ($materi_matpel_ids as $materi_matpel_id) {
                SekolahHasMateri::create([
                    'sekolah_id' => $sekolah->id,
                    'materi_matpel_id' => $materi_matpel_id,
                ]);
            }

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Archive
    public function archive(Request $request)
    {
        try {
            $sekolah = Sekolah::find($request->id);
            $sekolah->is_archived = 1;

            if ($sekolah->isDirty()) {
                $sekolah->save();
            }

            if ($sekolah->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Unarchive
    public function unarchive(Request $request)
    {
        try {
            $sekolah = Sekolah::find($request->id);
            $sekolah->is_archived = 0;

            if ($sekolah->isDirty()) {
                $sekolah->save();
            }

            if ($sekolah->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Delete Kelas
    public function delete(Request $request)
    {
        try {
            $sekolah = Sekolah::find($request->id);
            $sekolah->delete();

            if ($sekolah->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Blueprint
    public function blueprint($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        $sekolah = Sekolah::where('id', $id)->firstOrFail();

        $data = [
            'title' => 'Kisi-Kisi',
            'sekolah' => $sekolah,
        ];

        return view('contents.perumusan.blueprint.index', $data);
    }

    // Rubrik
    public function rubrik($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        $sekolah = Sekolah::where('id', $id)->firstOrFail();

        $data = [
            'title' => 'Rubrik',
            'sekolah' => $sekolah,
        ];

        return view('contents.perumusan.rubrik.index', $data);
    }

    // Multiple Materi Matpel
    public function getSelectedMateriMatpel($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);
        try {
            $sekolah_id = $id;

            $selected_materi_matpel_ids = SekolahHasMateri::where('sekolah_id', $sekolah_id)
                ->pluck('materi_matpel_id')
                ->toArray();

            return response()->json(['selected_materi_matpel_ids' => $selected_materi_matpel_ids]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve selected materi_matpel_ids'], 400);
        }
    }
}
