<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirect($service){
        $ss=Socialite::driver($service)->redirect();
        return response()->json($ss);
        //return $this->redirect($service);
    }
    public function callback($service){
        return $user=Socialite::with($service)->user();
        return response()->json($user);
    }
}
//return response()->json($work_time_statistic);
