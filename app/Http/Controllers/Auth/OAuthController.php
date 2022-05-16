<?php

namespace App\Http\Controllers\Auth;

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

            if ($oAuthType === 'github') {
                    $response = Http::withToken( Auth()->user()[$oAuthType.'_token'])
                    ->get('https://api.github.com/user');

                    if ($response->failed() && $response->status() === 401) {
                        return redirect('/auth/'.$oAuthType.'/redirect');
                    }
                    else if ($response->ok()) {
                        session()->put('data.github', [
                            'name' => $response->json()['name'],
                            'repos_url' => $response->json()['repos_url'],
                            'html_url' => $response->json()['html_url'],
                            'avatar_url' => $response->json()['avatar_url'],
                            'id' => $response->json()['id']
                            ]);

                            return view('home');
                }

            }


            else if ($oAuthType === 'google') {
                    $response = Http::withToken( Auth()->user()[$oAuthType.'_token'])
                    ->get('https://www.googleapis.com/oauth2/v1/userinfo?access_token='.Auth()->user()[$oAuthType.'_token']);

                    if ($response->failed() && $response->status() === 401) {
                        return redirect('/auth/'.$oAuthType.'/redirect');
                    }
                    elseif ($response->ok()) {
                        session()->put('data.google', [
                        'name' => $response->json()['name'],
                        'email' => $response->json()['email'],
                        'avatar_url' => $response->json()['picture'],
                        'id' => $response->json()['id']
                        ]);


                        return view('home');
                    }
            }

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
