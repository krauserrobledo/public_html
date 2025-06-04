<?php

namespace App\Services;

use App\Models\Reserva;
use App\Mail\ConfirmacionReserva;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function enviarConfirmacionReserva(Reserva $reserva)
    {
        try {
            Mail::to($reserva->user->email)
                ->send(new ConfirmacionReserva($reserva));
        } catch (\Exception $e) {
            \Log::error("Error al enviar email de confirmación: " . $e->getMessage());
        }
    }
}