<?php
namespace App\Repositories\Campaign;

interface CampaignRepository
{
	public function getCampaigns();
	public function getCampaign($world, $stage);
	public function progressPlayerCampaign($player_id);
}