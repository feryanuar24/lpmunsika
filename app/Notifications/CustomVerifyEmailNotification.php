<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class CustomVerifyEmailNotification extends Notification
{
    use Queueable;

    /** 
     * The verification URL.
     */
    public $url;

    /**
     * Create a new notification instance.
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Verifikasi Akun Anda')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Terima kasih telah mendaftar. Klik tombol di bawah untuk memverifikasi alamat email Anda:')
            ->action('Verifikasi Sekarang', $this->url)
            ->line('Link ini akan kedaluwarsa dalam 60 menit. Jika Anda tidak membuat akun, abaikan email ini.')
            ->salutation('Salam Pers Mahasiswa!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
