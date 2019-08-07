<?php
namespace App\Repositories\Player;

require_once base_path('app/Libraries/Constants.php');

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Player;
use App\Campaign;

class PlayerRepositoryImpl implements PlayerRepository
{
    public function __construct()
    {
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
			MOONLIGHT => ['rank' => 1],
		]);

		// create campaign entry
		$player->campaign()->attach([
			STARTING_CAMPAIGN_ID => [
				'last_used_chars' => '[]'
			]
		]);

		// set campaign chars
		$this->saveCampaignChars($player->fresh(), [
			(object)['char' => 'atroce', 'rank' => 1, 'pos' => 1]
		]);

		return $this->getPlayer($id);
	}

    public function getPlayers() 
	{
		return Player::all();
	}

    public function getPlayer($id) 
	{
		$player = Player::getRaw($id);
		if (!$player)
			return false;
				
		// normalize char list with keys
		$normalized = Player::normalizeCollection($player, 'chars', [
			'id' 		=> 'data.id',
			'char' 		=> 'code',
			'name' 		=> 'name',
			'sprite' 	=> 'sprite',
			'rank' 		=> 'data.rank',
		]);
		unset($player->chars);
		$player->chars = $normalized;

		// normalize item list with keys
		$normalized = Player::normalizeCollection($player, 'items', [
			'id' 		=> 'data.id',
			'item' 		=> 'code',
			'name' 		=> 'name',
			'sprite' 	=> 'sprite',
			'type' 		=> 'type',
			'qty' 		=> 'data.qty',
		]);
		unset($player->items);
		$player->items = $normalized;

		// normalize campaign data
		Campaign::normalizePlayerCampaignData($player);

		return $player;
	}

	public function saveCampaignChars($player, $chars)
	{
		// get player data if id is passed
		if (is_numeric($player)) {
			$player = Player::getRaw($player);
		}

		// format
		$chars_formatted = [null, null, null, null, null];
		foreach ($chars as $char) {
			$chars_formatted[$char->pos - 1] = $player->chars
												->where('code', $char->char)
												->where('data.rank', $char->rank)
												->first()->id;
		}

		$campaign = $player->campaign()->get()->first();
		$campaign->data->last_used_chars = json_encode($chars_formatted);
		$campaign->data->save();

		return true;
	}
}