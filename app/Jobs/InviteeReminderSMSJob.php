<?php

namespace App\Jobs;

use App\Helpers\SMSHelper;
use App\Models\Invitee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class InviteeReminderSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Invitee|Builder|Model
     */
    protected string                $message;
    protected string                $smsTo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $smsTo, string $message)
    {
        $this->message = $message;
        $this->smsTo   = $smsTo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            logger("Invitee reminder SMS job dispatched");
            SMSHelper::init($this->smsTo, $this->message)->sendSMS()->saveToDatabase();
            logger("SMS To: $this->smsTo");
            logger("Message: $this->message");
        }
        catch (\Exception $e) {
            logger("Invitee reminder SMS job failed: " . $e->getMessage());
        }
    }
}
