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
        $html = $website->text();

        $metaBlog = $website->filterXPath('//meta[@property="og:url"]')->attr('content');
        preg_match('/\/(\d+)$/', $metaBlog, $blogId);

        preg_match('/var odds1 = changeOdds\((\d+\.\d+),isEu\);/', $html, $odds1);
        preg_match('/var odds2 = changeOdds\((\d+\.\d+),isEu\);/', $html, $odds2);
        preg_match('/var odds3 = changeOdds\((\d+\.\d+),isEu\);/', $html, $odds3);

        preg_match('/content: "([^"]+)"/', $html, $content);
        preg_match('/\$\("#sp_score_(\d+)"\)\.html\(\'(\w+-\w+)\'\)/', $html, $score);

        $userTip = new UserTip([
            'title' => $website->filter('#blogtitle.title')->text(''),
            'content' => $content[1],
            'home_name' => $website->filter('.team .home')->text(''),
            'away_name' => $website->filter('.team .away')->text(''),
            // 'score' => $score[1],
            'fi' =>  null,
            'user_id' => $website->filter('#opr_follow')->attr('v-uid'),
            'blog_id' => $blogId[1] ?? null,
            'odds1' => $odds1[1] ?? null,
            'odds2' => $odds2[1] ?? null,
            'odds3' => $odds3[1] ?? null,
        ]);
        $userTip->save();
        return true;
    }
}
