<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'players';

    protected $fillable = [
    	'id', 'name', 'level', 'gold', 'diamond'
    ];
    
    public function campaign() 
    {
    	return $this->belongsToMany('App\Campaign', 'p_campaign')->withTimestamps()
                ->as('data')
                ->withPivot('last_used_chars')
                ->limit(1);
    }

    public function chars()
    {
    	return $this->belongsToMany('App\Char', 'p_chars')->withTimestamps()
                ->as('data')
                ->withPivot('id', 'rank');
    }

    public function items()
    {
    	return $this->belongsToMany('App\Item', 'p_items')->withTimestamps()
                ->as('data')
                ->withPivot('id', 'qty');
    }
}
