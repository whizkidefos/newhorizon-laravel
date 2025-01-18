<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile_phone' => ['required', 'string', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'job_role' => ['required', 'in:registered_nurse,healthcare_assistant,support_worker'],
            'dob' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:male,female'],
            'postcode' => ['required', 'string'],
            'address' => ['required', 'string'],
            'country' => ['required', 'string'],
            'ni_number' => ['required', 'string', 'unique:users'],
            'nationality' => ['required', 'in:UK,EU,Other'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'mobile_phone' => $data['mobile_phone'],
            'username' => $data['username'],
            'job_role' => $data['job_role'],
            'dob' => $data['dob'],
            'gender' => $data['gender'],
            'postcode' => $data['postcode'],
            'address' => $data['address'],
            'country' => $data['country'],
            'ni_number' => $data['ni_number'],
            'nationality' => $data['nationality'],
        ]);
    }
}