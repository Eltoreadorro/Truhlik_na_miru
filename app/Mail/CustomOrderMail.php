<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->markdown('emails.custom-order')
    ->with([
        'name' => $this->data['name'],
        'email' => $this->data['email'],
        'phone' => $this->data['phone'],
        'details' => $this->data['details'] // не message!
    ])
        ->subject('Nový individuální požadavek - Truhlík na Míru');
    }
}
