<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewContactNotification extends Notification
{
    use Queueable;
    public $contact;
    /**
     * Create a new notification instance.
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }


    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'contact_id' => $this->contact->id,
            'name' => 'تم إرسال رسالة جديدة من ' . $this->contact->name,
            'phoneNumber' => $this->contact->phoneNumber,
            'message' => $this->contact->message,
            'created_at' => now(),

        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('رسالة جديدة من المستخدم')
                    ->line('تم إرسال رسالة جديدة من ' . $this->contact->name)
                    ->line('الرسالة: ' . $this->contact->message);
    }


}
