<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExampleController extends ApiController
{
	public function test(Request $request)
	{
        return $this->respondSuccess(null, 'test');
	}
}
