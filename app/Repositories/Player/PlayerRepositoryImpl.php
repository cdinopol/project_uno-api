<?php
namespace App\Repositories\Player;

require_once base_path('app/Libraries/Constants.php');

use App\Player;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PlayerRepositoryImpl implements PlayerRepository
{
    public function __construct()
    {
    }

    public function getPlayers() 
	{
		return Player::all();
	}

    public function getPlayer($id) 
	{
		try {
			$player = Player::where('id', $id)
						->with(['chars', 'items', 'campaign'])
						->first();
		} catch (ModelNotFoundException $ex) {
			return false;
		}
				
		//normalize campaign data
		if (isset($player->campaign[0])) {
			$normalized_campaign = $player->campaign[0];
			unset($player['campaign']);
			$player['campaign'] = $normalized_campaign;
		}

		return $player;
	}

	public function newPlayer($id)
	{
		$player = Player::create([
			'id' => $id,
			'name' => DEFAULT_PLAYER_NAME,
			'level' => STARTING_PLAYER_LEVEL,
			'gold' => STARTING_PLAYER_GOLD,
			'diamond' => STARTING_PLAYER_DIAMOND
		]);

		// have to find before attaching for some reason
		$player = Player::findOrFail($id);

		// give first chars
		$player->chars()->attach([
			ATROCE => ['rank' => 1],
			MOONLIGHT => ['rank' => 1]
		]);
		
		// set campaign
		$player->fresh()->campaign()->attach([
			STARTING_CAMPAIGN_ID => ['last_used_chars' => json_encode(
				array_column(array_column($player->chars->toArray(), 'data'), 'id')
			)]
		]);

		return $this->getPlayer($id);
	}
}