<?php
namespace App\Factories\Drivers;

use Illuminate\Support\Facades\Http;
use App\Interfaces\DriverInterface;

class GoogleDriver implements DriverInterface {
    public function connect ($oAuthType) {
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
