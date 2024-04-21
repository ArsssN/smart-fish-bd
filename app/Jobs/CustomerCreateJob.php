<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CustomerCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The password.
     *
     * @var string
     */
    protected $password;

    /**
     * The email.
     *
     * @var string
     */
    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($password, $email)
    {
        $this->password = $password;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = \App\Models\User::query()->where('email', $this->email)->first();

        if ($user) {
            $user->notify(new \App\Notifications\CustomerCreateNotification($this->password));
        } else {
            \Illuminate\Support\Facades\Log::error('User not found with email: ' . $this->email);
        }
    }
}
