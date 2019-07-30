<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'p_items';

    protected $fillable = [
    	'player_id', 'item_id', 'qty'
    ];

    public function player()
    {
    	return $this->belongsTo('Player', 'player_id');
    }
}
