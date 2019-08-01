<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Char\CharRepository;

class CharController extends ApiController
{
    protected $rChar;

    public function __construct(Request $request, CharRepository $rChar)
    {
        $this->rChar = $rChar;

        parent::__construct($request);
    }

    public function getChars()
    {
    	$data = $this->rChar->getChars();
    	return $this->respond($data);
    }

    public function getChar($id)
    {
    	$data = $this->rChar->getChar($id);
    	return $this->respond($data);
    }
}
