<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateArticleNotification extends Notification
{
    use Queueable;

    private $article;

    /**
     * Create a new notification instance.
     */
    public function __construct($article)
    {
        $this->article = $article;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Artikel baru telah dipublikasikan',
            'message' => $this->article->title,
            'url' => route('detail', $this->article->slug),
        ];
    }
}
