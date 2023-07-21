<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;


class SpotifyService
{
	public $clientID;
	public $client;
	public $secretKey;
	public $api;
	public $token;

	public function __construct($token)
	{
		$this->api = 'https://api.spotify.com/v1/';
		$this->clientID = env('SPOTIFY_CLIENT_ID');
		$this->secretKey = env('SPOTIFY_CLIENT_SECRET');
		$this->token = $token;
		

	}

	public function search($search, $type, $offset)
	{

		$isCached = Cache::store('redis')->get($search.' + '.$offset);

		if ($isCached)
		{
		return $isCached;
		} else {
		$request = Http::withToken($this->token)->acceptJson()->get('https://api.spotify.com/v1/search', [
		'q' => $search,
		'type' => $type,
		'market' => 'US',
		'limit' => 50,
		'offset' => $offset ?? 0,
		]);
		}

		if ($request->ok())
		{
			 $response = json_decode($request->getBody(), true);
			 $total = $response['tracks']['total'];
			 $items = array_column($response, 'items');
			 $next = $response['tracks']['next'];
			 $response = array('total'=> $total, 'next'=> $next, 'items' => $items);
			 Cache::store('redis')->put($search.' + '.$offset, $response);
			 return array('total'=> $total, 'next'=> $next, 'items' => $items);
		} else {
			return $request->json();
		}
		
	}

	public function addItemToQueue($itemID, $device = null)
	{
		$lastColonPos = strrpos($itemID, ':');
		$substring = substr($itemID, $lastColonPos + 1);

		$request = Http::withToken($this->token)->post('https://api.spotify.com/v1/me/player/queue?uri='.'spotify:track:' . $substring);
		
		if ($request->ok())
		{
		return 'item added!';
		} elseif($request->status() == 401){
		return $request->json($key = 'error', $default = 'reason');
		} elseif($request->status() == 403){
		return $request->json($key = 'error', $default = 'reason');
		} elseif($request->status() == 429){
		return 'The app has exceeded its rate limits.';
		}
		
		//return 'spotify:track:' . $itemID; //
		//Poorly made api by Spotify, gotta include stuff in the query string not the request body sheesh //
		//return $request->json();
	}

	public function playbackState()
	{

		$request = Http::withToken($this->token)->get('https://api.spotify.com/v1/me/player');
		if ($request->ok())
		{
		return $request->json();
		} else {
		return $request->json();	
		}

	}

	public function queueInfo()
	{

		$request = Http::withToken($this->token)->get('https://api.spotify.com/v1/me/player/queue');
		if ($request->ok())
		{
		return $request->json();
		} else {
		return $request->json();	
		}

	}

	public function songsinQueue()
	{

		$request = Http::withToken($this->token)->get('https://api.spotify.com/v1/me/player/queue');
		if ($request->ok())
		{
		$queue = $request->json();
		$queue = $queue['queue'];
		return array_column($queue, 'id');
		}

	}

	public function nextSong()
	{

		$request = Http::withToken($this->token)->post('https://api.spotify.com/v1/me/player/next');
		if ($request->ok())
		{
		return true;
		} else {
		return $request->json();	
		}
		
	}

	public function prevSong()
	{

		$request = Http::withToken($this->token)->post('https://api.spotify.com/v1/me/player/previous');
		if ($request->ok())
		{
		return true;
		} else {
		return $request->json();	
		}
		
	}

	public function shuffle($toggle)
	{

		$request = Http::withToken($this->token)->put('https://api.spotify.com/v1/me/player/shuffle?state=' . $toggle);
		if ($request->ok())
		{
		return true;
		} else {
		return $request->json();	
		}

	}

	public function removeTrack($track)
	{
		//wishful thinking, not a featuere as far as I can see
	}

	public function songLookup($track)
	{
		$lastColonPos = strrpos($track, ':');
		$substring = substr($track, $lastColonPos + 1);

		$request = Http::withToken($this->token)->get('https://api.spotify.com/v1/tracks/' . $substring);
		if ($request->ok())
		{
		return $request->json();
		} else {
		return $request->json();	
		}
	}

	public function lookupCollection($collection)
	{
  	
	if ($collection[1])
	{
	$isCached = Cache::store('redis')->has($collection[1]);

	if ($isCached)
	{
	return Cache::store('redis')->get($collection[1]);
	}
	}


  	foreach ($collection as $k => $v)
  	{
  		$lastColonPos = strrpos($v, ':');
		$substring[] = substr($v, $lastColonPos + 1);
  	}
  	$commaSeparated = implode(', ', $substring);
  	$commaSeparated = str_replace(' ', '', $commaSeparated);

  	$request = Http::withToken($this->token)->get('https://api.spotify.com/v1/tracks/?ids=' . $commaSeparated);
  		
  		if ($request->ok())
		{
		Cache::store('redis')->put($collection[1], $request->json());
		return $request->json();
		} else {
		return $request->json();	
		}

	}
}
