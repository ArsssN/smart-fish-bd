<?php

namespace App\Notifications;

use Backpack\Settings\app\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class CustomerCreateNotification extends Notification
{
    use Queueable;

    /**
     * The password.
     *
     * @var string
     */
    protected $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($password)
    {
        $this->password = $password;
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
        $appLink = Setting::get('app_link') ?? '/app/download';
        return (new MailMessage)
            ->subject('New Account Created Successfully')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your account has been created successfully.')
            ->line(new HtmlString('Your username is: <strong>' . $notifiable->username . '</strong>'))
            ->line(new HtmlString('Your password is: <strong>' . $this->password . '</strong>'))
            ->action('Login', route('backpack.auth.login'))
            ->line('You can download our mobile app from the following links:')
            ->line(new HtmlString("<a href='{$appLink}'>Google Play Store</a>"))
            ->line('Thank you for using our application!');
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
