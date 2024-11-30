<?php

namespace App\Http\Controllers\Kepenyiaran;

use App\Models\RapmaNews;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class RapmaNewsController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Rapma News'
        ];

        return view('contents.kepenyiaran.rapma-news.list', $data);
    }

    public function data(Request $request)
    {
        $list = RapmaNews::select(DB::raw('*'));

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
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'link' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $data = [
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'tanggal' => $request->tanggal,
                'link' => $request->link,
            ];

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                $year = date('Y', strtotime($request->tanggal));
                $path = $file->store('public/uploads/rapma-news/' . $year);

                $encodedPath = Storage::url($path);
                $encodedPath = str_replace([' ', '#'], ['%20', '%23'], $encodedPath);

                $data['filename'] = $originalName;
                $data['path'] = $encodedPath;
            }

            RapmaNews::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'link' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $rapma_news = RapmaNews::find($request->id);
            $rapma_news->judul = $request->judul;
            $rapma_news->deskripsi = $request->deskripsi;
            $rapma_news->tanggal = $request->tanggal;
            $rapma_news->link = $request->link;

            if ($request->hasFile('image')) {
                if ($rapma_news->path) {
                    $decodedPath = str_replace(['%20', '%23'], [' ', '#'], $rapma_news->path);

                    if (file_exists(public_path($decodedPath))) {
                        unlink(public_path($decodedPath));
                    }
                }

                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                $year = date('Y', strtotime($request->tanggal));
                $path = $file->store('public/uploads/rapma-news/' . $year);

                $encodedPath = Storage::url($path);
                $encodedPath = str_replace([' ', '#'], ['%20', '%23'], $encodedPath);

                $rapma_news->filename = $originalName;
                $rapma_news->path = $encodedPath;
            }

            if ($rapma_news->isDirty()) {
                $rapma_news->save();
            }

            if ($rapma_news->wasChanged()) {
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
            $rapma_news = RapmaNews::find($request->id);

            if ($rapma_news) {
                if ($rapma_news->path) {
                    $decodedPath = str_replace(['%20', '%23'], [' ', '#'], $rapma_news->path);

                    if (file_exists(public_path($decodedPath))) {
                        unlink(public_path($decodedPath));
                    }
                }

                $rapma_news->delete();

                if ($rapma_news->trashed()) {
                    return response()->json(['status' => true], 200);
                }
            } else {
                return response()->json(['status' => false, 'msg' => 'Rapma News not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Switch Status
    public function switchStatus(Request $request)
    {
        try {
            $rapma_news = RapmaNews::find($request->id);
            $rapma_news->is_active = $request->value;

            if ($rapma_news->isDirty()) {
                $rapma_news->save();
            }

            if ($rapma_news->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}
