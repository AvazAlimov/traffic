<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
class TaxiOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }
    public function toTelegram($order)
    {
        $point1 = explode(",", $order->point_A, 2);
        $point2 = explode(",", $order->point_B, 2);
        $user=($order->user_type == 0) ? "Пользователь" : "Юридическое лицо";
        return TelegramMessage::create()
            ->to(-237163806) // Optional.
            ->content("*Такси - Новый Заказ!*\n*Ид:* ".$order->id."\n*Заказчик:* ".$user."\n*Дистанция (км): * ".$order->distance."\n*Время ожидания (мин):* ".$order->minute."\n*Имя:* ".$order->name."\n*Тел:* ".$order->phone."\n*Откуда:* ".$order->address_A."\n*Куда:* ".$order->address_B."\n*Время подачи:* ".$order->start_time."\n*Цена:* ".$order->price
            );

    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
