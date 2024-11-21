<?php

namespace App\Http\Controllers;

use App\Models\TopCharts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class TopChartsController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Top Charts'
        ];

        return view('contents.top-charts.list', $data);
    }

    public function data(Request $request)
    {
        $list = TopCharts::select(DB::raw('*'));

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
            'versi' => 'required|string',
            'link' => 'required|string',
        ]);

        try {
            $data = [
                'versi' => $request->versi,
                'link' => $request->link,
            ];

            TopCharts::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'versi' => 'required|string',
            'link' => 'required|string',
        ]);

        try {
            $top_charts = TopCharts::find($request->id);
            $top_charts->versi = $request->versi;
            $top_charts->link = $request->link;

            if ($top_charts->isDirty()) {
                $top_charts->save();
            }

            if ($top_charts->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Delete
    public function delete(Request $request)
    {
        try {
            $top_charts = TopCharts::find($request->id);
            $top_charts->delete();

            if ($top_charts->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}
