<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\SoundMembers;
use App\Models\Spotify;


class SpotifyController extends Controller
{
    public $provider;
    /**
     * Redirect the user to the Socialite authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        if ($provider == 'spotify') {
            
            return Socialite::driver($provider)
            ->scopes(['user-read-email', 'user-modify-playback-state', 'user-read-playback-state'])
            ->redirect();
            
        //return Socialite::driver($provider)->redirect();
        } else {
        return Socialite::driver($provider)->redirect();
        }
    }

    /**
     * Obtain the user information from Socialite.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {

        $socialiteUser = Socialite::driver($provider)->user();
        
        Cache::store('redis')->put("SpotifyAuth", $socialiteUser);

        $user = User::firstOrCreate(
            [
                'provider_id' => $socialiteUser->getId(),
                'provider' => $provider,
            ],
            [   
                'provider_id' => $socialiteUser->getId(),
                'provider' => $provider,
                'email' => $socialiteUser->getEmail() ?? $socialiteUser->getName() . '@bataboom.dev',
                'name' => $socialiteUser->getName(),
                'password' => Hash::make(Str::random(16)),
                
            ]
        );

        if ($provider == 'spotify')
        {
        $user->refresh_token = $socialiteUser->refreshToken;
        $user->save();
        
        $record = Spotify::firstOrCreate(
        ['host_id' => $user->id],
        [
        'host_id' => $user->id, 'access_token' => $socialiteUser->accessTokenResponseBody['access_token'], 'active' => 1,
        ]
        );
        }

        // Log the user in
        auth()->login($user, true);

        if($record)
        {
        return redirect()->route('sound.party', ['partykey' => $record->party_key]);
        }

        // Redirect to dashboard
        return redirect('/dashboard');
        
    }

    public function signup()
    {
        return view('spotify.start');
    }

    public function index()
    {
        return view('spotify.index');
    }

    public function show($partykey, Request $request)
    {

        $findParty = Spotify::Where('party_key', $partykey)->exists();
        if ($findParty)
        {
        $findParty = Spotify::Where('party_key', $partykey)->pluck('id')->first();
        $record = SoundMembers::firstOrCreate(
            ['party_id' => $findParty, 'session_id'=> $request->session()->getId() ],
            ['party_id' => $findParty, 'session_id'=> $request->session()->getId(), 'ip_address' => $request->ip()]
        );
        }
        if (isset($record))
        {
        return view('spotify.index', ['partykey' => $partykey, 'partyCount' => SoundMembers::Where('party_id', $findParty)->count()]);
         } else {
        return abort(404);  
        }
    }

    

}
