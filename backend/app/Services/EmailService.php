<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class EmailService
{
    public function sendEmail($email)
    {
        sleep(5);
        Log::info('Mensaje enviado al correo: ' . $email);
    }
}
