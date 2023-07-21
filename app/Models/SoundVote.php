<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoundVote extends Model
{
    use HasFactory;
    protected $table = 'sound_vote';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $incrementing = true;

    public function party()
    {
        return $this->belongsTo(Spotify::Class, 'id', 'party_id');
    }


    public function scopeSongCount($query, $song)
     {
        return $query->where('song_id', $song)
        ->where('skip', true)->count();
     }

}
