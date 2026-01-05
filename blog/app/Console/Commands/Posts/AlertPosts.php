<?php

namespace App\Console\Commands\Posts;

use App\Jobs\Posts\AlertJob;
use App\Models\AlertPost;
use Illuminate\Console\Command;

class AlertPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:dispatch-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Despacha jobs para processar alerts pendentes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        AlertPost::whereNull('processed_at')
            ->chunk(50, function($alerts){
                foreach ($alerts as $alert) {
                    AlertJob::dispatch($alert);
                }
            });
        return 0;
    }
}
