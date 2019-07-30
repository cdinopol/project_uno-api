<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Char extends Model
{
    protected $table = 'p_chars';

    protected $fillable = [
    	'player_id', 'char_id', 'rank', 'level'
    ];

    public function player()
    {
    	return $this->belongsTo('Player', 'player_id');
    }
}
