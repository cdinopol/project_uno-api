<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Player\PlayerRepository;

class PlayerController extends ApiController
{
    protected $rPlayer;

    public function __construct(PlayerRepository $rPlayer)
    {
        $this->rPlayer = $rPlayer;
    }
}
