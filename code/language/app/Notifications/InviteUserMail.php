<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\App;

class InviteUserMail extends Notification implements ShouldQueue
{
    use Queueable;

    public $language;
    public $token;
    public $email;

    /**
     * Create a new notification instance.
     *
     * @param $language
     * @param $token
     * @param $email
     */
    public function __construct($language, $token, $email)
    {
        $this->language = $language;
        $this->token = $token;
        $this->email = $email;

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
        $url = url("/{$this->language}/project/invite/{$this->token}");

        return (new MailMessage)
            ->line(trans('inviteUserMail.join_project'))
            ->action(trans('inviteUserMail.join'), url($url));
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
