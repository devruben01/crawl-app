<?php

namespace App\Console\Commands;

use App\Services\CrawlUserTipsServices;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CrawlTipsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:tips-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'crawl:tips-data';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(CrawlUserTipsServices $crawlUserTipsServices)
    {
        try {
            $crawlTime = Carbon::now()->format("Y-m-d H:i:s");
            Log::info('Start push Notification firebase: ' . $crawlTime);
            $crawlUserTipsServices->crawlTipsData('https://tips.bongdalu666.com/article/916370');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }
}