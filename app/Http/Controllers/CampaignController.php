<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request ;
use App\Repositories\Campaign\CampaignRepository;
use App\Repositories\Player\PlayerRepository;

class CampaignController extends ApiController
{
    protected $rCampaign;
    protected $rPlayer;

    public function __construct(Request $request, CampaignRepository $rCampaign, PlayerRepository $rPlayer)
    {
        $this->rCampaign = $rCampaign;
        $this->rPlayer = $rPlayer;

        parent::__construct($request);
    }

    public function getCampaign($world, $stage)
    {
        $data = $this->rCampaign->getCampaign($world, $stage);
        return $this->respond($data);
    }

    public function verifyWin()
    {
        if (true) {
            // give rewards


            // next campaign or done
            $data = $this->rCampaign->progressPlayerCampaign($this->player_id);
            return $this->respondSuccess($data);
        } 

        return $this->respondFailed();
    }

    public function setPlayerChars(Request $request)
    {
        $chars = $request->input('chars');
        if (!$chars)
            return $this->respondFailed();

        $player = $this->rPlayer->getPlayer($this->player_id);
        $player_chars = $player->chars;

        // arrange for easy lookup
        $player_chars_lookup = [];
        foreach($player_chars as $player_char) {
            if (!isset($player_chars_lookup[$player_char['char'].'_'.$player_char['rank']])) {
                $player_chars_lookup[$player_char['char'].'_'.$player_char['rank']] = $player_char['id'];
            }
        }
        
        // search and save if ok
        $data = [];
        foreach($chars as $char) {
            if (!isset($player_chars_lookup[$char['char'].'_'.$char['rank']])) {
                return $this->respondFailed();
            }

            $data[] = (object)['char' => $char['char'], 'rank' => $char['rank'], 'pos' => $char['pos']];
        }

        $this->rPlayer->saveCampaignChars($this->player_id, $data);
        
        return $this->respondSuccess($this->rPlayer->getPlayer($this->player_id)->campaign->data->last_used_chars);
    }
}
