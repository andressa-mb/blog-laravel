<?php

namespace App\Jobs\Followers;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AlertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var App\User
     */
    public $follower_id;

    /**
    * @var App\User
    */
    public $authorToFollow;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $authorToFollow, int $follower_id)
    {
        $this->authorToFollow = $authorToFollow;
        $this->follower_id = $follower_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->authorToFollow->alertNewFollowers()->create([
            'follower_id' => $this->follower_id,
            'processed_at' => now()
        ]);
    }
}
