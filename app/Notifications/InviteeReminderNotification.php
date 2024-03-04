<?php

namespace App\Notifications;

use App\Models\Event;
use App\Models\Invitee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteeReminderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param Invitee|Model|Builder $invitee
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(Invitee|Model|Builder $invitee)
    {
        $invitation = $invitee->invitation;
        $event      = $invitation->event;

        $url = url(config('app.frontend_base_url') . $invitation->urlBase);
        $url .= "?code=$invitation->code&dontSendOtpImmediately=1";

        logger("Invitee reminder email job dispatched");

        return (new MailMessage)
            ->subject("Reminder of event: $event->title")
            ->greeting("Hello $invitee->name!")
            ->line("You have been invited to an event on $event->start_date. Please click the button below to view the invitation.")
            ->action('Event Details', $url)
            ->line('If you have any questions, please contact us.')
            ->line('Thanks!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
