<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignData extends Model
{
    protected $table = 'p_campaign_data';

    protected $fillabe = [
    	'campaign_id', 'last_used_chars'
    ];

    public function player()
    {
    	return $this->belongsTo('Player', 'player_id');
    }
}
