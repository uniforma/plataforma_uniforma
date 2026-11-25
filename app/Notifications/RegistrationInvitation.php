<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationInvitation extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $submissionId,
        public string $title,
        public string $type,
    ) {
        $this->afterCommit();
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Inscrições abertas — '.$this->title)
            ->greeting('Olá, '.$notifiable->name.'!')
            ->line('A demanda “'.$this->title.'”, que você apoiou na UniForma, foi oficializada.')
            ->line('As inscrições estão abertas. Formato da formação: '.$this->type.'.')
            ->action('Fazer inscrição', route('offers.show', $this->submissionId));
    }
}