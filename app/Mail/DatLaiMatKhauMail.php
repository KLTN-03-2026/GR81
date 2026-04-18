<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DatLaiMatKhauMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $resetUrl;
    public string $hoTen;

    public function __construct(string $resetUrl, string $hoTen)
    {
        $this->resetUrl = $resetUrl;
        $this->hoTen = $hoTen;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Đặt lại mật khẩu - MBTI-CRS',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.dat-lai-mat-khau',
        );
    }
}
