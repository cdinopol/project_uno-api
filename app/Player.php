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

    public static function getRaw($id)
    {
        try {
            return Player::where('id', $id)
                        ->with(['chars', 'items', 'campaign'])
                        ->first();
        } catch (ModelNotFoundException $ex) {
            return false;
        }
    }

    public static function normalizeCollection($player_data, $collection, $keys)
    {
        if (!isset($player_data[$collection]))
            return false;

        $collection_arr = $player_data[$collection];
        $normalized = [];

        foreach($collection_arr as $k => $x) {
            $normalized[$x['data']['id']] = [];
            
            foreach($keys as $key => $xkey) {
                $subkeys = explode('.', $xkey);
                $tmp_arrv = $collection_arr[$k];

                foreach($subkeys as $subkey) {
                    $tmp_arrv = $tmp_arrv[$subkey];
                }

                $normalized[$x['data']['id']][$key] = $tmp_arrv;
            }
        }

        return $normalized;
    }
}
