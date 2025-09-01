<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    protected $fillable = ['phone', 'otp', 'expires_at'];
}
