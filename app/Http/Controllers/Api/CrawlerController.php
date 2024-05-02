<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserTip;
use App\Services\SampleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class CrawlerController extends Controller
{
    public function __construct(private SampleService $sampleService)
    {
    }

    public function index(Request $request)
    {
        $client = new Client();
    
        $website = $client->request('GET', 'https://tips.bongdalu666.com/article/916370');
        dd([
            'title' => $website->filter('#blogtitle.title')->text(),
            'content' => $website->filter('.hideContent')->text(''),
        ]);
        return $website->html();
    }
}
