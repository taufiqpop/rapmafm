<?php

namespace App\Http\Controllers;

use App\Models\Achievements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AchievementsController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Achievements'
        ];

        return view('contents.achievements.list', $data);
    }

    public function data(Request $request)
    {
        $list = Achievements::select(DB::raw('*'));

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
            'tahun' => 'required|string',
            'order' => 'required|string',
            'link' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $data = [
                'judul' => $request->judul,
                'tahun' => $request->tahun,
                'order' => $request->order,
                'link' => $request->link,
            ];

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                $path = $file->store('public/uploads/achievements/' . $request->tahun);

                $encodedPath = Storage::url($path);
                $encodedPath = str_replace([' ', '#'], ['%20', '%23'], $encodedPath);

                $data['filename'] = $originalName;
                $data['path'] = $encodedPath;
            }

            Achievements::create($data);

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
            'tahun' => 'required|string',
            'order' => 'required|string',
            'link' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $achievements = Achievements::find($request->id);
            $achievements->judul = $request->judul;
            $achievements->tahun = $request->tahun;
            $achievements->order = $request->order;
            $achievements->link = $request->link;

            if ($request->hasFile('image')) {
                if ($achievements->path) {
                    $decodedPath = str_replace(['%20', '%23'], [' ', '#'], $achievements->path);

                    if (file_exists(public_path($decodedPath))) {
                        unlink(public_path($decodedPath));
                    }
                }

                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                $path = $file->store('public/uploads/achievements/' . $request->tahun);

                $encodedPath = Storage::url($path);
                $encodedPath = str_replace([' ', '#'], ['%20', '%23'], $encodedPath);

                $achievements->filename = $originalName;
                $achievements->path = $encodedPath;
            }

            if ($achievements->isDirty()) {
                $achievements->save();
            }

            if ($achievements->wasChanged()) {
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
            $achievements = Achievements::find($request->id);

            if ($achievements) {
                if ($achievements->path) {
                    $decodedPath = str_replace(['%20', '%23'], [' ', '#'], $achievements->path);

                    if (file_exists(public_path($decodedPath))) {
                        unlink(public_path($decodedPath));
                    }
                }

                $achievements->delete();

                if ($achievements->trashed()) {
                    return response()->json(['status' => true], 200);
                }
            } else {
                return response()->json(['status' => false, 'msg' => 'Event not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Switch Status
    public function switchStatus(Request $request)
    {
        try {
            $achievements = Achievements::find($request->id);
            $achievements->is_active = $request->value;

            if ($achievements->isDirty()) {
                $achievements->save();
            }

            if ($achievements->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}
