<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Player\PlayerRepository;
use App\Repositories\Campaign\CampaignRepository;

class PlayerController extends ApiController
{
    protected $rPlayer;
    protected $rCampaign;

    public function __construct(Request $request, PlayerRepository $rPlayer, CampaignRepository $rCampaign)
    {
        $this->rPlayer = $rPlayer;
        $this->rCampaign = $rCampaign;

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
       
        if (!$player_data) {
            // register as new player if self request and not found
            if ($id == null) {
                $player_data = $this->rPlayer->newPlayer($this->player_id);
            }

            // return error
            else {
                return $this->respondError();
            }
        }
    	
    	return $this->respond($player_data);
    }

    public function getChars($id = null)
    {
        return $this->respond($this->rPlayer->getPlayer($id ?? $this->player_id)->chars);
    }

    public function getItems($id = null)
    {
        return $this->respond($this->rPlayer->getPlayer($id ?? $this->player_id)->items);
    }
}
