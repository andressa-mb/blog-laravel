<?php

namespace App\Jobs\Posts;

use App\Models\AlertPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AlertJob implements ShouldQueue
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
    public function __construct(AlertPost $alert)
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
        Log::info($this->alert);

        if ($this->alert->processed_at !== null) {
            return;
        }

        foreach($author->followers as $follower){
            $follower->alertFollowers()->create([
                'alert_id' => $this->alert->id,
                'author_id' => $author->id,
                'post_id' => $this->alert->post_id,
            ]);
        }

        $this->alert->update(['processed_at' => now()]);
    }
}
