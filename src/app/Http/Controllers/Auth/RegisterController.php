<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\PreRegister;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;

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
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function preregister(Request $request)
    {
      $emailValidator = [
        'email' => ['required', 'string', 'email', 'unique:users'],
      ];

      $this->validate($request, $emailValidator);

      $preRegister = PreRegister::whereEmail($request->json('email'))->first();

      if ($preRegister) {
        $preRegister->update([
          'token' => Str::random(250),
          'expiration_time' => Carbon::now()->addHours(1),
        ]);
      } else {
        $preRegister = PreRegister::create([
          'email' => $request->json('email'),
          'token' => Str::random(250),
          'status' => PreRegister::SEND_MAIL,
          'expiration_time' => Carbon::now()->addHours(1),
        ]);
      }

      $mail = new EmailVerification($preRegister);
      Mail::to($preRegister->email)->send($mail);

      return Response::json([], 201);
    }

    public function verify(Request $request)
    {
      $preUser = PreRegister::whereToken($request->json('token'))->first();

      if (
        is_null($preUser)
        || $preUser->status == PreRegister::REGISTERED
        || Carbon::now()->gt($preUser->expiration_time)
      ) {
        return Response::json([], 422);
      }

      $preUser->update(['status' => PreRegister::MAIL_VERIFY]);

      return Response::json([], 200);
    }
}
