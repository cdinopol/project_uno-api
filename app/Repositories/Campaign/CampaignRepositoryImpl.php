<?php
namespace App\Repositories\Campaign;

use App\Campaign;
use App\Player;
use Illuminate\Support\Facades\DB;


class CampaignRepositoryImpl implements CampaignRepository
{
    public function __construct()
    {
    }

    public function getCampaigns()
	{
		return Campaign::all();
	}

	public function getCampaign($world, $stage)
	{
		$campaign = Campaign::where([
			'world' => $world,
			'stage' => $stage
		])->first();

		// normalize enemies
		Campaign::normalizeCampaignEnemies($campaign);
		// unset($campaign->enemies);
		// $campaign->enemies = $normalized;

		return $campaign;
	}

	public function progressPlayerCampaign($player_id)
	{
		$current_player_campaign_id = Player::find($player_id)->campaign()->first()->id;
		$next_campaign = Campaign::getNextCampaign($current_player_campaign_id);

		if ($next_campaign)  {
			Player::find($player_id)->campaign()->sync([$next_campaign->id]);
		}

		return $next_campaign;
	}
}