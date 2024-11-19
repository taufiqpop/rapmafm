<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // Form Register
    public function showRegistrationForm(Request $request)
    {
        $data = [
            'title' => 'Register'
        ];

        return view('auth.register', $data);
    }

    // Register
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        return DB::transaction(function () use ($request) {
            $user = $this->create($request->all());

            event(new Registered($user));

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk ke akun Anda.');
        });
    }

    // Create
    protected function create(array $data)
    {
        $data = [
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'real_password' => $data['password'],
        ];

        $user = User::create($data);

        $defaultRoleId = null;
        $user->roles()->attach($defaultRoleId);

        return $user;
    }

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Validator
    protected function validator(array $data)
    {
        $messages = [
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.regex' => 'Kata sandi harus mengandung minimal satu huruf dan satu angka.',
            'password_confirmation.required' => 'Konfirmasi kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ];

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'],
        ];

        return Validator::make($data, $rules, $messages);
    }
}
