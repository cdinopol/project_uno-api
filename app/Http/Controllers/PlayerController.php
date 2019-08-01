<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Player\PlayerRepository;

class PlayerController extends ApiController
{
    protected $rPlayer;

    public function __construct(Request $request, PlayerRepository $rPlayer)
    {
        $this->rPlayer = $rPlayer;

        parent::__construct($request);
    }

    public function getPlayers()
    {
    	$data = $this->rPlayer->getPlayers();
    	return $this->respond($data);
    }

    public function getPlayer($id = null)
    {
    	$player_data = $this->rPlayer->getPlayer($id ?? $this->player_id);

        // register as new player if self request and not found
        if (!$player_data && $id === null) {
            $player_data = $this->rPlayer->newPlayer($this->player_id);
        }
    	
    	return $this->respond($player_data);
    }
}
