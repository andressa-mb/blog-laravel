<?php

namespace App\Console\Commands\Posts;

use App\Models\Post;
use Illuminate\Console\Command;

class DeleteTrashedCmd extends Command
{
    /**
     * The name and signature of the console command.
     * php artisan command:delete-trashed-posts
     * @var string
     */
    protected $signature = 'command:delete-trashed-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Post::onlyTrashed()->limit(10)->get()->each(function ($post){
            $post->forceDelete();
        });
        return 0;
    }
}
