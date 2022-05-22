<?php
namespace App\Factories\Drivers;

use Illuminate\Support\Facades\Http;
use App\Interfaces\DriverInterface;

class GithubDriver implements DriverInterface {
    public function connect ($oAuthType) {
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
}
