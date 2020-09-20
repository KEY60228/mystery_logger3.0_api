<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreRegister extends Model
{
  const SEND_MAIL = 0;
  const MAIL_VERIFY = 1;
  const REGISTER = 2;

  protected $fillable = [
    'email', 'token', 'status', 'expiration_time'
  ];
}
