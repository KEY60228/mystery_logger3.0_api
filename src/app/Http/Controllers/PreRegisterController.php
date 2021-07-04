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
     * @param App\Http\Requests\PreRegisterRequest $request
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

        if (app()->isLocal()) {
            $mail = new EmailVerification($preRegister);
            Mail::to($preRegister->email)->send($mail);
        } else {
            $sqs = app()->make('aws')->createClient('sqs');
            $params = [
                'DelaySeconds' => 0,
                'MessageBody' => 'nazolog/preregister/mail',
                'QueueUrl' => config('aws.sqs.url'),
                'MessageAttributes' => [
                    'email' => [
                        'DataType' => 'String',
                        'StringValue' => $preRegister->email,
                    ],
                    'token' => [
                        'DataType' => 'String',
                        'StringValue' => $preRegister->token,
                    ],
                    'expiration_time' => [
                        'DataType' => 'String',
                        'StringValue' => $preRegister->expiration_time
                    ]
                ],
            ];
            $sqs->sendMessage($params);
        }

        return Response::json([], 201);
    }

    /**
     * メールアドレス認証処理
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Support\Facades\Response
     */
    public function verify(Request $request)
    {
        $preUser = PreRegister::whereToken($request->json('token'))->first();

        if (
            is_null($preUser)
            || $preUser->status == PreRegister::REGISTERED
            || Carbon::now()->gt($preUser->expiration_time)
        ) {
            return Response::json([
                'errors' => [
                    'verify' => [
                        'トークンが不正です。'
                    ]
                ],
                'message' => 'The given token was invalid.'
            ], 422);
        }

        $preUser->update(['status' => PreRegister::MAIL_VERIFY]);

        return Response::json([
            'email' => $preUser->email,
            'pre_register_id' => $preUser->id,
        ], 200);
    }
}
