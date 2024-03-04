<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UserCreatedFromInviteeNotification extends Notification
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
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        sleep(1);
        $login = config("app.frontend_base_url") . "/login";

        $html =
            "A new account has been created for you on our website. You can login to your account using the following credentials:";
        $html .= "<br><br>";
        $html .= "<strong>Username: <code>$notifiable->username</code></strong>";
        $html .= "<br>";
        $html .= "<strong>Password: <code>$notifiable->username</code></strong>";
        $html .= "<br><br>";
        $html .= "You can login to your account by clicking:";

        return (new MailMessage)
            ->subject("New Account Created in " . config("app.name"))
            ->greeting("Hello $notifiable->name!")
            ->line(new HtmlString($html))
            ->action('Login here', url($login))
            ->line('Good day!');
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
