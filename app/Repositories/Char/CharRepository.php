<?php
namespace App\Repositories\Char;

interface CharRepository
{
	public function getChars();
	public function getChar($id);
}