<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Char\CharRepository;

class CharController extends ApiController
{
    protected $rChar;

    public function __construct(CharRepository $rChar)
    {
        $this->rChar = $rChar;
    }
}
