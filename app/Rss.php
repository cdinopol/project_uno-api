<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rss extends Model
{
    protected $table = 'p_rss';

    protected $fillabe = [
    	'gold', 'diamond'
    ];

    public function player()
    {
    	return $this->belongsTo('Player', 'player_id');
    }
}
