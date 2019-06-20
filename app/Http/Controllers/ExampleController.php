<?php

namespace App\Http\Controllers;

class ExampleController extends ApiController
{
    public function get_user_id()
    {
        return $this->respondSuccess('Good job! Good luck with your API!', $this->user);
    }
}
