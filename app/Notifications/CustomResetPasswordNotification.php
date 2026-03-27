<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * The password reset token.
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
            ->subject('Atur Ulang Kata Sandi Anda')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda. Klik tombol di bawah untuk membuat kata sandi baru:')
            ->action('Atur Ulang Kata Sandi', $this->url)
            ->line('Tautan ini hanya berlaku selama 60 menit. Jika Anda tidak meminta pengaturan ulang kata sandi, abaikan email ini.')
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
