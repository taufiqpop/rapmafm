<?php

namespace App\Http\Controllers\Umum;

use App\Models\Pemancar;
use App\Models\PemancarKondisiSuara;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class PemancarController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Pemancar'
        ];

        return view('contents.umum.pemancar.list', $data);
    }

    public function data(Request $request)
    {
        $list = Pemancar::select(DB::raw('*'))->with(['daerah']);

        return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('encrypted_id', function ($row) {
                return Crypt::encryptString($row->id);
            })
            ->make();
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|string',
            'coordinates' => 'nullable|string',
            'coordinate_type' => 'nullable|string',
            'nama_daerah' => 'nullable|array',
            'kondisi_suara' => 'nullable|array',
        ]);

        try {
            $data = [
                'tanggal' => $request->tanggal,
                'coordinates' => $request->coordinates,
                'coordinate_type' => $request->coordinate_type,
            ];

            $pemancar = Pemancar::create($data);

            if ($request->has('nama_daerah') && is_array($request->nama_daerah)) {
                $nama_daerah = $request->nama_daerah;
                $kondisiSuara = $request->kondisi_suara ?? [];

                foreach ($nama_daerah as $index => $daerah) {
                    if (!empty($daerah) && isset($kondisiSuara[$index])) {
                        PemancarKondisiSuara::create([
                            'pemancar_id' => $pemancar->id,
                            'nama_daerah' => $daerah,
                            'kondisi_suara' => $kondisiSuara[$index]
                        ]);
                    }
                }
            }

            return response()->json(['status' => true, 'id' => $pemancar->id], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|string',
            'coordinates' => 'nullable|string',
            'coordinate_type' => 'nullable|string',
            'nama_daerah' => 'nullable|array',
            'kondisi_suara' => 'nullable|array',
        ]);

        try {
            $pemancar = Pemancar::find($request->id);
            $pemancar->tanggal = $request->tanggal;
            $pemancar->coordinates = $request->coordinates;
            $pemancar->coordinate_type = $request->coordinate_type;

            if ($pemancar->isDirty()) {
                $pemancar->save();
            }

            if ($request->has('nama_daerah') && is_array($request->nama_daerah)) {
                $nama_daerah = $request->nama_daerah;
                $kondisiSuara = $request->kondisi_suara ?? [];

                PemancarKondisiSuara::where('pemancar_id', $pemancar->id)->delete();

                foreach ($nama_daerah as $index => $daerah) {
                    if (!empty($daerah) && isset($kondisiSuara[$index])) {
                        PemancarKondisiSuara::create([
                            'pemancar_id' => $pemancar->id,
                            'nama_daerah' => $daerah,
                            'kondisi_suara' => $kondisiSuara[$index]
                        ]);
                    }
                }
            }

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => 'terjadi'], 400);
        }
    }

    // Delete
    public function delete(Request $request)
    {
        try {
            $pemancar = Pemancar::find($request->id);
            $pemancar->delete();

            if ($pemancar->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Delete Daerah
    public function deleteDaerah(Request $request)
    {
        try {
            $nama_daerah = PemancarKondisiSuara::findOrFail($request->id);
            $nama_daerah->delete();

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}
