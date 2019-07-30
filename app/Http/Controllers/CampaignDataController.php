<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CampaignData\CampaignDataRepository;

class CampaignDataController extends ApiController
{
    protected $rCampaignData;

    public function __construct(CampaignDataRepository $rCampaignData)
    {
        $this->rCampaignData = $rCampaignData;
    }
}
