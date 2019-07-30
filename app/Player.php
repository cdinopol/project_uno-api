<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'players';

    protected $fillable = [
    	'id', 'name'
    ];

    public function rss()
    {
    	return $this->hasOne('Rss', 'player_id');
    }

    public function campaign_data() 
    {
    	return $this->hasOne('CampaignData', 'player_id');
    }

    public function chars()
    {
    	return $this->hasMany('Char', 'player_id');
    }

    public function items()
    {
    	return $this->hasMany('Item', 'player_id');
    }
}
