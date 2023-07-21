<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\SpotifyService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Spotify;
use App\Models\SoundVote;
use App\Models\SoundMembers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;


class Skippy extends Component
{
    public $host;
    public $search;
    public $img;
    public $artists;
    public $albums;
    public $offset;
    public $uri;
    public $partykey;
    public $skiptrack;
    public $saved = false;
    public $joined = false;
    public $members;
    public $member;
    public $locateParty;
    public $sessionID;
    public $tracks;
    public $test;
    private SpotifyService $spotifySrvc;
    private $token;
    public $premium = true;


    protected $queryString = ['search'];
    

    public function mount($partykey)
    {

    $this->offset = 0;
    $this->test = 0;
    $this->partykey = $partykey;
    $this->host = $this->setHost();
    $this->locateParty = Spotify::Where('party_key', $this->partykey)->pluck('id')->first();
    $this->members = SoundMembers::Where('party_id', $this->locateParty)->count();
    $this->member = $this->checkMember();
    $this->spotifySrvc = new SpotifyService($this->startSpotify());


    }


    public function currentURL()
    {
        return 'https://bataboom.dev/party/'  . $this->partykey;
    }


    public function startSpotify()
    {
        if (Cache::store('redis')->has($this->partykey . '_token')) {
        return Cache::store('redis')->get($this->partykey . '_token');
        } else {
        $host = $this->setHost();
        $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
        'grant_type' => 'refresh_token',
        'refresh_token' => $host->refresh_token,
        'client_id' => env('SPOTIFY_CLIENT_ID'),
        'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
        ]);

        if($response->ok())
        {
            $responseData = $response->json();
            Cache::store('redis')->put($this->partykey . '_token', $responseData['access_token'], now()->addMinutes(50));
            Cache::store('redis')->put('SpotifyAuth', $responseData['access_token']);
            return $this->token = $responseData['access_token'];

        }
        }
    }

    public function refreshSpotifySession()
    {
        if (Cache::store('redis')->has($this->partykey . '_token')) {
        return Cache::store('redis')->get($this->partykey . '_token');
        } else {
        $this->spotifySrvc = new SpotifyService($this->startSpotify());
        }


    }

    public function setHost()
    {

    $findParty =  Spotify::Where('party_key', $this->partykey)->pluck('host_id')->first();

    $host = User::Find($findParty);

    return $host;

    }

    public function clearInput()
    {
       $this->reset('search');
       $this->reset('albums');
       $this->reset('artists');
       $this->reset('img');
       
       
    }


    public function loadMore()
    {
    
    $this->offset += 50;
    $this->reset('albums');
       $this->reset('artists');
       $this->reset('img');
    $this->searchSpotify();

    }

    public function joinParty(Request $request)
    {

        
        $record = SoundMembers::firstOrCreate(
        ['session_id' => $this->member[0]],
        [
        'party_id' => $this->locateParty,
        'session_id' => $this->member[0],
        'ip_address' => $request->ip(),
        ]);
        
        if($record)
        {
        $this->joined = true;
        }

    }


    public function isRegistered()
    {
        return SoundMembers::Where('session_id', $this->member[0])->exists();
    }

    public function checkMember()
    {
       if(Session::has($this->locateParty))
       {
       //
       } else {
        Session::put($this->locateParty, [Str::random(40)]);
       }
        $this->member = Session::get($this->locateParty);
       //return Session::get($this->locateParty);
        return $this->member;
    }

   
    public function searchSpotify()
    {
        if ($this->search !== null)
        {
        $s = new SpotifyService($this->startSpotify());
        $fetch = $s->search($this->search, 'track', $this->offset);
        $getItems = $fetch['items'];
        $this->uri = array_column($getItems[0], 'uri');
        $this->albums = array_column($getItems[0], 'album');
        $this->artists = array_column($this->albums, 'artists');
        $src = array_column($this->albums, 'external_urls');
        
        $this->img = array_column($this->albums, 'images');

        if (count($this->uri) > 1)
        {
        $cleanSearchFSpotify = $s->lookupCollection($this->uri);
        $this->tracks = array_column($cleanSearchFSpotify['tracks'], 'name');
        }
        //$this->emit('newSearchQuery');
        }

        //$this->results = [$this->uri,  $this->img, $this->albums,  $this->artists];
        $this->dispatch('results');

        return $this->img ?? null;
        
    }

    public function addToQueue($trackID)
    {

        $s = new SpotifyService($this->startSpotify());
        $s->addItemToQueue($trackID);
        $songLookup = $s->songLookup($trackID);

        if ($songLookup !== null)
        {
            
            $songName = $songLookup['name'];
        //$this->js("notyf.success($songName.' + Added to queue!')");
        $this->js("notyf.success('Added to queue!')");
        } else {
        $this->js("notyf.error('Error! This action requires a premium spotify account')");
        }

    }

    public function viewQueue()
    {
        $theQueue = [];

        $s = new SpotifyService($this->startSpotify());
        $queue = $s->queueInfo();

        if ($queue !== null)
        {
        $currentSong = array_column($queue, 'name');
        $currentSongId = array_column($queue, 'uri');
        $queueNames = array_column($queue['queue'], 'name');
        $queueIDs = array_column($queue['queue'], 'uri');
        if ($currentSong)
        {
        array_unshift($queueNames, $currentSong[0]);
        array_unshift($queueIDs, $currentSongId[0]);

        }
        $theQueue = array_combine($queueIDs, $queueNames);
        //return $queueNames;
        return $theQueue;
        } else {
            $this->premium = false;
        }

    }

   
    public function nextSong()
    {
        $s = new SpotifyService($this->startSpotify());
        $s->nextSong();
    }

    public function prevSong()
    {
        $s = new SpotifyService($this->startSpotify());
        $s->prevSong();
    }

    public function voteToSkip(Request $request)
    {

        $queue = $this->viewQueue();
        if(isset($queue[$this->skiptrack[0]]))
        {
        $record = SoundVote::firstOrCreate(
        ['session_id' => $this->member[0], 'song_id' => $this->skiptrack[0]],
        [
        'party_id' => $this->locateParty,
        'session_id' => $this->member[0],
        'song_id' => $this->skiptrack[0],
        'skip' => true,
        ]);

        if ($record)
        {
        $this->saved = true;
        $this->js("notyf.success('Voted to Skip!')"); 
        
        }

    }
    }

    public function votedtoSkipSongs()
    {
        
        $votedSongs = SoundVote::Where('party_id', $this->locateParty)->pluck('song_id')->unique()->toArray();

        if ($votedSongs) {
        foreach ($votedSongs as $k => $v)
        {
        $votes[] = SoundVote::songCount($v);
        }

        return array_combine($votedSongs, $votes);
        }
    }

    public function skipService()
    {
        $skips = $this->votedtoSkipSongs();
        $memberCount = $this->members;
        $halfCount = intval(ceil($memberCount / 2));
        return $this->test += 50;

    }

    public function hydrate()
    {

        $this->viewQueue();
        $this->searchSpotify();
        $this->votedtoSkipSongs();
        //$this->refreshSpotifySession();
        $this->skipService();
        
    }



    public function render()
    {
        return view('livewire.skippy')->with([
        'results' => $this->searchSpotify() ?? null,
        'tracksids' => $this->uri ?? null,
        'queue' => $this->viewQueue() ?? null,
        'host' => $this->host,
        'skips' => $this->votedtoSkipSongs() ?? null,
        'isRegistered' => $this->isRegistered() ?? null,
        'url' => $this->currentURL(),
        ]);
    }
}
