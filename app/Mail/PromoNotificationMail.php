<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PromoNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $promoProducts;
    public $userName;

    public function __construct($promoProducts, $userName)
    {
        $this->promoProducts = $promoProducts;
        $this->userName = $userName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔥 Promo Spesial untuk Anda! - Fashionista Store',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.promo-notification',
        );
    }
}