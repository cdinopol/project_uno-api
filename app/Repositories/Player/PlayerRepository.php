<?php
namespace App\Repositories\Player;

interface PlayerRepository
{
	public function newPlayer($id);
	public function getPlayers();
	public function getPlayer($id);
	public function saveCampaignChars($player, $chars);
}