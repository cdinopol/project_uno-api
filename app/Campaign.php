<?php

namespace App;

use DB; 
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'static_campaign';

    public static function getNextCampaign($id)
	{
        return Campaign::where('id', DB::select(DB::raw("
            SELECT COALESCE(
				(
					SELECT id FROM static_campaign 
					WHERE world = (SELECT world FROM static_campaign WHERE id = {$id})
					AND stage = (SELECT stage FROM static_campaign WHERE id = {$id}) + 1
					LIMIT 1
				),
				(
					SELECT id FROM static_campaign 
					WHERE world = (SELECT world FROM static_campaign WHERE id = {$id}) + 1
					ORDER BY stage ASC
					LIMIT 1
				),
				'-1'
			) as 'id'
        "))[0]->id)->first();
    }

    public static function normalizePlayerCampaignData(&$player_data)
    {
    	if (!isset($player_data->campaign) || $player_data->campaign == null)
    		return false;

    	// normalize data
        $normalized_campaign = $player_data->campaign->first();
        unset($player_data->campaign);
        $player_data->campaign = $normalized_campaign;

        // normalize last used chars
    	$campaign_chars = json_decode($player_data->campaign->data->last_used_chars);
    	unset($player_data->campaign->data->last_used_chars);
    	$chars = $player_data->chars;
    	
    	$data = [];
		foreach($campaign_chars as $k => $player_char_id) {
			if ($player_char_id) {
				$chars[$player_char_id]['pos'] = $k+1;
				$data[] = $chars[$player_char_id];
			}
		}
		
		$player_data->campaign->data->last_used_chars = $data;
    }

    public static function normalizeCampaignEnemies(&$campaign_data)
    {
    	if (!isset($campaign_data->enemies) || $campaign_data->enemies == null)
    		return false;

    	$enemies = json_decode($campaign_data->enemies);

    	// get ids
    	$ids = [];
    	foreach($enemies as $enemy) {
    		if ($enemy != null) {
    			$ids[] = key($enemy);
    		}
    	}

    	// get char details
    	$chars = DB::table('static_chars')
                    ->whereIn('id', $ids)
                    ->get()->keyBy('id');

        // format data
        $data = [];
        foreach($enemies as $k => $enemy) {

        	// skip nulls
        	if ($enemy == null)
        		continue;

        	$id = key($enemy);
        	$data[] = [
        		'pos' => $k+1,
        		'char'=> $chars[$id]->code,
        		'rank' => current($enemy)
        	];
        }

        unset($campaign_data->enemies);
        $campaign_data->enemies = $data;
    }
}

