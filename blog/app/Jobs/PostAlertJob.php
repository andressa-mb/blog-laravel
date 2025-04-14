<?php

namespace App\Jobs;

use App\Models\PostAlert;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PostAlertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var PostAlert
     */
    public $alert;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PostAlert $alert)
    {
        $this->alert = $alert;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $author = $this->alert->author;
        foreach($author->followers as $follower){
            $follower->alerts()->create([
                'alert_id' => $this->alert->id,
                'author_id' => $author->id,
                'post_id' => $this->alert->post_id,
            ]);
        }
    }
}
