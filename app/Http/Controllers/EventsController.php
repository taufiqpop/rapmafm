<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class EventsController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Events'
        ];

        return view('contents.events.list', $data);
    }

    public function data(Request $request)
    {
        $list = Events::select(DB::raw('*'));

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
            'jenis_event' => 'required|string',
            'nama_event' => 'required|string',
            'tahun' => 'required|string',
            'order' => 'required|string',
            'link' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $data = [
                'jenis_event' => $request->jenis_event,
                'nama_event' => $request->nama_event,
                'tahun' => $request->tahun,
                'order' => $request->order,
                'link' => $request->link,
            ];

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                $path = $file->store('public/uploads/events/' . $request->tahun . '/' . $request->jenis_event . '/' . $request->nama_event);

                $encodedPath = Storage::url($path);
                $encodedPath = str_replace([' ', '#'], ['%20', '%23'], $encodedPath);

                $data['filename'] = $originalName;
                $data['path'] = $encodedPath;
            }

            Events::create($data);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update
    public function update(Request $request)
    {
        $request->validate([
            'jenis_event' => 'required|string',
            'nama_event' => 'required|string',
            'tahun' => 'required|string',
            'order' => 'required|string',
            'link' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $events = Events::find($request->id);
            $events->jenis_event = $request->jenis_event;
            $events->nama_event = $request->nama_event;
            $events->tahun = $request->tahun;
            $events->order = $request->order;
            $events->link = $request->link;

            if ($request->hasFile('image')) {
                if ($events->path) {
                    $decodedPath = str_replace(['%20', '%23'], [' ', '#'], $events->path);

                    if (file_exists(public_path($decodedPath))) {
                        unlink(public_path($decodedPath));
                    }
                }

                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                $path = $file->store('public/uploads/events/' . $request->tahun . '/' . $request->jenis_event . '/' . $request->nama_event);

                $encodedPath = Storage::url($path);
                $encodedPath = str_replace([' ', '#'], ['%20', '%23'], $encodedPath);

                $events->filename = $originalName;
                $events->path = $encodedPath;
            }

            if ($events->isDirty()) {
                $events->save();
            }

            if ($events->wasChanged()) {
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
            $events = Events::find($request->id);

            if ($events) {
                if ($events->path) {
                    $decodedPath = str_replace(['%20', '%23'], [' ', '#'], $events->path);

                    if (file_exists(public_path($decodedPath))) {
                        unlink(public_path($decodedPath));
                    }
                }

                $events->delete();

                if ($events->trashed()) {
                    return response()->json(['status' => true], 200);
                }
            } else {
                return response()->json(['status' => false, 'msg' => 'Event not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    public function switchStatus(Request $request)
    {
        try {
            $events = Events::find($request->id);
            $events->is_active = $request->value;

            if ($events->isDirty()) {
                $events->save();
            }

            if ($events->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}
