<?php

namespace App\Jobs;

use App\Helpers\InvitationCardHelper;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\Invitee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class InviteeInsertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array               $invitee;
    protected Event|Builder|Model $event;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($invitee, Event|Builder|Model $event)
    {
        $this->invitee = $invitee;
        $this->event   = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $invitee = Invitee::query()->create($this->invitee);

        $code = createUniqueInvitationCode(8, $eventId = $invitee->id, $inviteeId = $this->event->id);

//        $image = (new InvitationCardHelper)->generate($this->event, $invitee);
//        $card  = $image;

        Invitation::query()->create([
            'invitee_id' => $eventId,
            'event_id'   => $inviteeId,
            'code'       => $code,
//            'card'       => $card,
        ]);

        logger('Invitee created: ' . $invitee->name);
    }
}
