<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Rss\RssRepository;

class RssController extends ApiController
{
    protected $rRss;

    public function __construct(RssRepository $rRss)
    {
        $this->rRss = $rRss;
    }
}
