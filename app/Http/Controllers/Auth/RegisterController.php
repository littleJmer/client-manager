<?php

namespace App\Http\Controllers\Auth;

use App\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/app/dashboard';

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
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }   

    /*
     ______     __   __   ______     ______     ______     __     _____     ______    
    /\  __ \   /\ \ / /  /\  ___\   /\  == \   /\  == \   /\ \   /\  __-.  /\  ___\   
    \ \ \/\ \  \ \ \'/   \ \  __\   \ \  __<   \ \  __<   \ \ \  \ \ \/\ \ \ \  __\   
     \ \_____\  \ \__|    \ \_____\  \ \_\ \_\  \ \_\ \_\  \ \_\  \ \____-  \ \_____\ 
      \/_____/   \/_/      \/_____/   \/_/ /_/   \/_/ /_/   \/_/   \/____/   \/_____/                                                                           
    */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = new User([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // save
        $user->save();

        // login
        $credentials = request(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $request->session()->flash('sysmsg', 'Welcome to Client Manager!');
            return response()->json(['message' => 'Successfully created user!'], 201);
        }

    }
}
