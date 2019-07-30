<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Item\ItemRepository;

class ItemController extends ApiController
{
    protected $rItem;

    public function __construct(ItemRepository $rItem)
    {
        $this->rItem = $rItem;
    }
}
