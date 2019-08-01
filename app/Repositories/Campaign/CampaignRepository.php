<?php
namespace App\Repositories\Campaign;

interface CampaignRepository
{
	public function getCampaigns();
	public function getCampaign($id);
	public function progressPlayerCampaign($player_id);
}