<?php

namespace App\Services;

use App\Constants\Constants;
use App\Models\UserTip;
use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CrawlUserTipsServices
{
    public function __construct(

    ) {
    }

    /**
     * @param $url
     * @return true
     */
    public function crawlTipsData($url)
    {
        Log::info('run job');
        return $url;
//        $client = new Client();
//        $website = $client->request('GET', $url);
//        $html = $website->text();
//
//        $metaBlog = $website->filterXPath('//meta[@property="og:url"]')->attr('content');
//        preg_match('/\/(\d+)$/', $metaBlog, $blogId);
//
//        preg_match('/var odds1 = changeOdds\((\d+\.\d+),isEu\);/', $html, $odds1);
//        preg_match('/var odds2 = changeOdds\((\d+\.\d+),isEu\);/', $html, $odds2);
//        preg_match('/var odds3 = changeOdds\((\d+\.\d+),isEu\);/', $html, $odds3);
//        preg_match('/content: "([^"]+)"/', $html, $content);
//        preg_match('/\$\("#sp_score_(\d+)"\)\.html\(\'(\w+-\w+)\'\)/', $html, $score);
//        $userTip = new UserTip([
//            'title' => $website->filter('#blogtitle.title')->text(''),
//            'content' => $content[1],
//            'home_name' => $website->filter('.team .home')->text(''),
//            'away_name' => $website->filter('.team .away')->text(''),
//            // 'score' => $score[1],
//            'fi' =>  null,
//            'user_id' => $website->filter('#opr_follow')->attr('v-uid'),
//            'blog_id' => $blogId[1] ?? null,
//            'odds1' => $odds1[1] ?? null,
//            'odds2' => $odds2[1] ?? null,
//            'odds3' => $odds3[1] ?? null,
//        ]);
//        $userTip->save();
//        return true;
    }

}