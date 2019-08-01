<?php
namespace App\Repositories\Player;

interface PlayerRepository
{
	public function getPlayers();
	public function getPlayer($id);
	public function newPlayer($id);
}