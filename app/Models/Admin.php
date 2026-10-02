<?php

namespace App\Models;

use App\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends User
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasApiTokens, HasRoles;
    protected $guarded = [];
}