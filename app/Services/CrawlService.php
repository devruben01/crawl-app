<?php

namespace App\Services;

use App\Models\UserTip;
use Goutte\Client;

class CrawlService
{
    public function crawlData(string $url)
    {
        $client = new Client();

        $website = $client->request('GET', $url);
        $html = $website->html();

        $title = $website->filter('#blogtitle.title')->text('');
        
        if (empty($title)) {
            return false;
        }

        $metaBlog = $website->filterXPath('//meta[@property="og:url"]')->attr('content');
        preg_match('/\/(\d+)$/', $metaBlog, $blogId);

        preg_match('/var odds1 = changeOdds\((\d+\.\d+),isEu\);/', $html, $odds1);
        preg_match('/var odds2 = changeOdds\((\d+\.\d+),isEu\);/', $html, $odds2);
        preg_match('/var odds3 = changeOdds\((\d+\.\d+),isEu\);/', $html, $odds3);

        $fiText = $website->filter('.matchBox .col-4.links')->html();
        preg_match('/\b\d+\b/', $fiText, $fi);

        preg_match('/content: "([^"]+)"/', $html, $content);
        preg_match('/\$\("#sp_score_(\d+)"\)\.html\(\'(\w+-\w+)\'\)/', $html, $score);
        $values = $website->filter('span.val')->each(function ($node) {
            return $node->text();
        });

        $regexIsEnd = '/var\s+isEnd\s*=\s*([\d]+)/';
        $regexIsWin = '/var\s+isWin\s*=\s*([\d]+)/';
        $regexIsRun = '/var\s+isRun\s*=\s*([\d]+)/';

        preg_match($regexIsEnd, $html, $matchesIsEnd);
        preg_match($regexIsWin, $html, $matchesIsWin);
        preg_match($regexIsRun, $html, $matchesIsRun);


        $regexDataWeek = '/data-week="([^"]+)"/';
        $regexDataMonth = '/data-month="([^"]+)"/';
        preg_match($regexDataWeek, $html, $dataWeek);
        preg_match($regexDataMonth, $html, $dataMonth);

        $dataWeek = !empty($dataWeek[1]) ? explode(',', $dataWeek[1] ?? '') : [];
        $dataMonth = !empty($dataMonth[1]) ? explode(',', $dataMonth[1] ?? '') : [];

        $userTip = new UserTip([
            'title' => $title,
            'content' => $content[1] ?? null,
            'home_name' => $website->filter('.team .home')->text(''),
            'away_name' => $website->filter('.team .away')->text(''),
            // 'score' => $score[1],
            'fi' =>  $fi[0],
            'user_info' => [
                'id' => $website->filter('#opr_follow')->attr('v-uid', ''),
                'username' => $website->filter('.Grounp .userDetailBox div.name')->text(''),
                'total_blog' => $values[0] ?? null,
                'follow' => $values[1] ?? null,
                'fans' => $values[2] ?? null,
                'statistics_week' => [
                    'win_rate' => $dataWeek[0] ?? null,
                    'roi' => $dataWeek[1] ?? null,
                    'tip' => $dataWeek[2] ?? null,
                    'avg_odds' => $dataWeek[3] ?? null,
                ],
                'statistics_moth' => [
                    'win_rate' => $dataMonth[0] ?? null,
                    'roi' => $dataMonth[1] ?? null,
                    'tip' => $dataMonth[2] ?? null,
                    'avg_odds' => $dataMonth[3] ?? null,
                ]
            ],
            'blog_id' => $blogId[1] ?? null,
            'odds1' => $odds1[1] ?? null,
            'odds2' => $odds2[1] ?? null,
            'odds3' => $odds3[1] ?? null,
            'is_win' => $matchesIsWin[1] ?? null,
            'is_end' => $matchesIsEnd[1] ?? null,
            'is_run' => $matchesIsRun[1] ?? null,
        ]);
        $userTip->save();
        return true;
    }
}
