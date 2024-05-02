<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserTip;
use App\Services\SampleService;
use Illuminate\Http\Request;
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
        $metaBlog = $website->filterXPath('//meta[@property="og:url"]')->attr('content');
        preg_match('/\/(\d+)$/', $metaBlog, $blogId);

        $userTip = new UserTip([
            'title' => $website->filter('#blogtitle.title')->text(''),
            'content' => $website->filter('#dvOdds_916370')->text(''),
            'fi' =>  null,
            'user_id' => $website->filter('#opr_follow')->attr('v-uid'),
            'blog_id' => $blogId[1] ?? null,
            'op' => $website->filter('.home.on')->text(''),
            'ah' => $website->filter('.vs span')->text(''),
            'ou' => $website->filter('.guest')->text(''),
        ]);
        $userTip->save();
        return true;
    }
}
