<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request ;
use App\Repositories\Campaign\CampaignRepository;

class CampaignController extends ApiController
{
    protected $rCampaign;

    public function __construct(Request $request, CampaignRepository $rCampaign)
    {
        $this->rCampaign = $rCampaign;

        parent::__construct($request);
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
}
