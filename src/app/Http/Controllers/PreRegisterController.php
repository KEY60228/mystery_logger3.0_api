<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Requests\PreRegisterRequest;
use App\Models\PreRegister;
use App\Mail\EmailVerification;
use Carbon\Carbon;

class PreRegisterController extends Controller
{
    /**
     * 仮登録処理
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Support\Facades\Response
     */
    public function preregister(PreRegisterRequest $request)
    {
        if ($preRegister = PreRegister::whereEmail($request->email)->first()) {
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
}
