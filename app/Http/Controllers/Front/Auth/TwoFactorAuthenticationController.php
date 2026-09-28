<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class TwoFactorAuthenticationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('Front.auth.TwoFactorAuth', compact('user'));
    }
}
