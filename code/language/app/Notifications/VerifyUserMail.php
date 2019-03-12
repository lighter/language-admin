<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\App;

class VerifyUserMail extends Notification
{
    use Queueable;

    public $user;
    public $lang;

    /**
     * Create a new notification instance.
     *
     * @param $user
     * @param $lang
     */
    public function __construct($user, $lang)
    {
        $this->user = $user;
        $this->lang = $lang;

        App::setLocale($this->lang);
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url("/#/{$this->lang}/user/verify/{$this->user->verifyUser->token}");

        return (new MailMessage)
            ->line(trans('verifyUserMail.check_email', ['email_id' => $this->user->email]))
            ->action(trans('verifyUserMail.verify_email'), url($url));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
