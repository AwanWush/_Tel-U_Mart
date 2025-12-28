<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public $title;

    public function __construct($order, $title)
    {
        $this->order = $order;
        $this->title = $title;
    }

    public function build()
    {
        return $this->subject($this->title)
            ->view('emails.order_update') // Pastikan nama file sesuai
            ->with([
                'order' => $this->order,
            ]);
    }
}
