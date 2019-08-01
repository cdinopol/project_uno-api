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

	public function getCampaign($id)
	{
		return Campaign::find($id)->first();
	}

	public function progressPlayerCampaign($player_id)
	{
		$current_player_campaign_id = Player::find($player_id)->campaign()->first()->id;
		$next_campaign = $this->getNextCampaign($current_player_campaign_id);

		if ($next_campaign)  {
			Player::find($player_id)->campaign()->sync([$next_campaign->id]);
		}

		return $next_campaign;
	}

	private function getNextCampaign($id)
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
}