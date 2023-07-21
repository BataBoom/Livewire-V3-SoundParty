<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Spotify extends Model
{
    use HasFactory;

    protected $table = 'sound';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $incrementing = true;

    /* Create Unique Blog Slugs */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sound) {
            try {
                $slug = Str::uuid();
                $sound->party_key = $slug;
            } catch (\Exception $e) {
                // Handle the exception here
                \Log::error('Error creating sound party: ' . $e->getMessage());
                return new Response(['error' => 'Unable to create sound party'], 500);
            }
        });
    }
}
