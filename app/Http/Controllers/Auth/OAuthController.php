<?php

namespace App\Http\Controllers\Auth;

use App\Factories\DriverFactory;
use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;
use App\Models\User;


class OAuthController extends Controller
{
    public function connect ($oAuthType) {

        if (Auth()->user()[$oAuthType.'_token']) {
            return (new DriverFactory)->create($oAuthType);
        }

        else {
            return redirect('/auth/'.$oAuthType.'/redirect');
        }

    }
    public function handleRedirect ($oAuthType) {
        return Socialite::driver($oAuthType)->redirect();
    }
    public function handleCallback ($oAuthType) {
        $user = Socialite::driver($oAuthType)->user();

        $userExisted = User::where('email',$user->email)->where('oauth_'.$oAuthType.'_id',$user->id)->first();
        if ($userExisted) {
            User::where('oauth_'.$oAuthType.'_id',$user->id)->update([
                $oAuthType.'_token' => $user->token
            ]);
            $user = $userExisted;
        }

        elseif (User::where('email',$user->email)->first()) {
            User::where('email', $user->email)->update([
                'oauth_'.$oAuthType.'_id' => $user->id,
                $oAuthType.'_token' => $user->token
            ]);
            $user = User::where('email',$user->email)->first();
        }
        else {
            $user = User::create([
                'email' => $user->email,
                'name' => $user->name,
                'password' => Hash::make($user->id),
                'oauth_'.$oAuthType.'_id' => $user->id,
                $oAuthType.'_token' => $user->token,
            ]);
        }

        Auth::login($user);
        return redirect('/home');
    }
}
