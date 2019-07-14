<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\App;

class VerifyUserMail extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;
    public $language;

    /**
     * Create a new notification instance.
     *
     * @param $user
     * @param $language
     */
    public function __construct($user, $language)
    {
        $this->user = $user;
        $this->language = $language;

        App::setLocale($this->language);
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
        $url = url("/{$this->language}/user/verify/{$this->user->verifyUser->token}");

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
