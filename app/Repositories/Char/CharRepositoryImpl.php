<?php
namespace App\Repositories\Char;

use App\Char;
use Illuminate\Support\Facades\DB;


class CharRepositoryImpl implements CharRepository
{
    public function __construct()
    {
    }

    public function getChars()
    {
    	return Char::all();
    }

    public function getChar($id)
    {
    	return Char::where('id', $id)
    			->orWhere('code', $id)
    			->first();
    }
}