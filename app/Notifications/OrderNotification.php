<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class OrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     * @return array
     * @internal param mixed $notifiable
     */
    public function via()
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($order)
    {
        $user = ($order->user_type == 0) ? "Пользователь" : "Юридическое лицо";
        $unit = $order->tarif->type == 0 ? "*Срок аренды (час):* " : "*Дистанция (км):* ";
        return TelegramMessage::create()
            ->to(-237163806)// Optional.
            ->content("*Грузоперевозка - Новый Заказ!*\n*Ид:* " . $order->id . "\n*Заказчик:* " . $user . "\n*Тариф:* " . $order->tarifName() . "\n*Количество грузчиков:* " . $order->persons . "\n*Авто:* " . $order->getCarName() . "\n" . $unit . $order->unit . "\n*Имя:* " . $order->name . "\n*Тел:* " . $order->phone . "\n*Откуда:* " . $order->address_A . "\n*Куда:* " . $order->address_B . "\n*Время подачи:* " . $order->start_time . "\n*Цена:* " . $order->sum
            );

    }

    /**
     * Get the mail representation of the notification.
     * @return MailMessage
     * @internal param mixed $notifiable
     */
    public function toMail()
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     * @return array
     * @internal param mixed $notifiable
     */
    public function toArray()
    {
        return [
            //
        ];
    }
}
