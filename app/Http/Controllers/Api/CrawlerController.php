<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CrawlService;
use Illuminate\Http\Request;

class CrawlerController extends Controller
{
    public function __construct(private CrawlService $crawlService)
    {
    }

    public function index(Request $request)
    {
        return $this->crawlService->crawlData('https://tips.bongdalu666.com/article/916370');
    }
}
