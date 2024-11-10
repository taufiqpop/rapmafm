<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Role;
use App\Models\TerminologiHasUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    // List Users
    public function index(Request $request)
    {
        $roles = Role::all();
        $data = [
            'title' => 'Pengguna',
            'roles' => $roles,
        ];

        return view('contents.user.list', $data);
    }

    public function data(Request $request)
    {
        $list = User::select(DB::raw('id, name, username, is_active, created_at'))->with('roles');

        return DataTables::of($list)
            ->addIndexColumn()
            ->make(true);
    }

    // Store User
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:5',
            'confirmation_password' => 'required|same:password'
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);

            for ($terminologiId = 1; $terminologiId <= 5; $terminologiId++) {
                TerminologiHasUser::create([
                    'user_id' => $user->id,
                    'terminologi_id' => $terminologiId,
                ]);
            }

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update User
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => ['required', Rule::unique('users', 'username')->ignore($request->id)]
        ]);

        try {
            $user = User::find($request->id);

            $user->name = $request->name;
            $user->username = $request->username;

            if ($user->isDirty()) {
                $user->save();
            }

            if ($user->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Switch Status User
    public function switchStatus(Request $request)
    {
        try {
            $user = User::find($request->id);

            $user->is_active = $request->value;

            if ($user->isDirty()) {
                $user->save();
            }

            if ($user->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Reset Password
    public function resetPassword(Request $request)
    {
        try {
            $user = User::find($request->id);

            $user->password = Hash::make('pengguna12345');

            if ($user->isDirty()) {
                $user->save();
            }

            if ($user->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Change Password
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:5',
            'confirmation_password' => 'required|same:password'
        ]);

        try {
            $user = User::find(Auth::id());

            $user->password = Hash::make($request->password);

            if ($user->isDirty()) {
                $user->save();
            }

            if ($user->wasChanged()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Delete User
    public function delete(Request $request)
    {
        try {
            $user = User::find($request->id);

            $user->delete();

            if ($user->trashed()) {
                return response()->json(['status' => true], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Update Role
    public function updateRole(Request $request)
    {
        try {
            $user_id = $request->id;
            $role_id = $request->role_id;

            $user = User::with('roles')->find($user_id);

            $roles = Role::select('id')->where('is_active', 1)->get();

            $user->roles()->sync($role_id);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }

    // Get Profile
    public function getProfile()
    {
        try {
            $user = Auth::user();

            return response()->json([
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => 'Gagal mengambil data pengguna.'], 400);
        }
    }

    // Change Profile
    public function changeProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'email' => 'nullable|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        try {
            $user = User::find(Auth::id());

            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;

            if ($user->isDirty()) {
                $user->save();

                return response()->json(['status' => true, 'msg' => 'Profil berhasil diperbarui.'], 200);
            }

            return response()->json(['status' => true, 'msg' => 'Tidak ada perubahan pada profil.'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()], 400);
        }
    }
}
