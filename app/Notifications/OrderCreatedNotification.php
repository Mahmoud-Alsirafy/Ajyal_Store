<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $order;
    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // return ['mail', 'database', 'broadcast'];
        return ['broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $addr = $this->order->billingAddress;
        // dd($addr);
        return (new MailMessage)
            ->subject('Thank you for your order, ' . ($addr->first_name ?? 'Customer') . '!')
            ->from('notification@gmail.com', 'Mahmoud Wael')
            ->line("Thank you for your order, (#{$this->order->number}) created by (#{$addr->first_name})")
            ->action('View Order', url('/dashboard'))
            ->line('Thank you for using our application!');
    }


    public function toDatabase($notifiable)
    {
        $addr = $this->order->billingAddress;
        return [
            'body' => 'Thank you for your order, ' . ($addr->first_name ?? 'Customer') . '!',
            'icon' => 'fas fa-file ',
            'url' => url('http://127.0.0.1:8000/dashboard'),
        ];
    }

    public function toBroadcast($notifiable)
    {
        $addr = $this->order->billingAddress;
        return new BroadcastMessage([
            'body' => 'Thank you for your order, ' . ($addr->first_name ?? 'Customer') . '!',
            'icon' => 'fas fa-file ',
            'url' => url('http://127.0.0.1:8000/dashboard'),
        ]);
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