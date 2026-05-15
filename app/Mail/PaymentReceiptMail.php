<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $vecinoName, public $filePath) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo Justificante de Pago - Cerro Muriano Pádel',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-receipt', // Crearemos esta vista ahora
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->filePath),
        ];
    }
}