<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\TerminologiHasUser;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    //use RegistersUsers;
    /**
     * Display the registration form based on role_id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        $role_id = $request->query('role_id', 2);
        return view('auth.register', compact('role_id'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        return DB::transaction(function () use ($request) {
            $user = $this->create($request->all());

            event(new Registered($user));

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk ke akun Anda.');
        });
    }

    /**
     * Validate the incoming request for registration.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);

        for ($terminologiId = 1; $terminologiId <= 5; $terminologiId++) {
            TerminologiHasUser::create([
                'user_id' => $user->id,
                'terminologi_id' => $terminologiId,
            ]);
        }

        $defaultRoleId = 2;
        $user->roles()->attach($defaultRoleId);
        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        // Aksi setelah user terdaftar
    }

    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
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
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    //   
}
