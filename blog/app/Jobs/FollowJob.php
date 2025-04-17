<?php

namespace App\Jobs;

use App\Models\Following;
use App\Models\FollowingAlert;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FollowJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var App\User
     */
    public $follow_id;

    /**
    * @var App\User
    */
    public $author;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $author, int $follow_id)
    {
        $this->author = $author;
        $this->follow_id = $follow_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->author->newFollowerAlerts()->create([
            'follower_id' => $this->follow_id,
        ]);
    }
}
