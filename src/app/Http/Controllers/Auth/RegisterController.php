<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\PreRegister;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\RegisterRequest;

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
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'account_id' => $data['account_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'pre_register_id' => $data['pre_register_id'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * 本登録処理
     * 
     * @param App\Http\Requests\RegisterRequest $request
     * @return Illuminate\Support\Facades\Response
     */
    public function register(RegisterRequest $request)
    {
        $preUser = PreRegister::find($request->pre_register_id);

        if (
            is_null($preUser)
            || $preUser->status != PreRegister::MAIL_VERIFY
            || $preUser->email != $request->email
        ) {
            return Response::json([
                'errors' => [
                    'pre_register' => [
                        'メールアドレスが未認証です。'
                    ]
                ],
                'message' => 'The given data was invalid.'
            ], 422);
        }

        event(new Registered($user = $this->create($request->all())));
        $preUser->update([
            'status' => PreRegister::REGISTERED,
        ]);

        $this->guard()->login($user);

        return Response::json([
            'id' => $user->id,
            'account_id' => $user->account_id,
            'name' => $user->name,
            'follows_id' => $user->follows_id,
            'followers_id' => $user->followers_id,
            'done_id' => $user->done_id,
            'wanna_id' => $user->wanna_id,
            'like_reviews_id' => $user->like_reviews_id,
        ], 201);
    }
}
