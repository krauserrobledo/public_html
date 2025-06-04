<?php

namespace App\Services;

use App\Models\Reserva;
use Stripe\StripeClient;

class PagoService
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    public function crearPago(Reserva $reserva, $monto)
    {
        try {
            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $monto * 100, // Convertir a centavos
                'currency' => 'eur',
                'metadata' => [
                    'reserva_id' => $reserva->id,
                    'user_id' => $reserva->user_id
                ],
                'description' => "Depósito del 20% para reserva #{$reserva->id}"
            ]);

            return $paymentIntent->client_secret;
        } catch (\Exception $e) {
            \Log::error("Error al crear pago: " . $e->getMessage());
            throw $e;
        }
    }

    public function confirmarPago($paymentIntentId)
    {
        $paymentIntent = $this->stripe->paymentIntents->retrieve($paymentIntentId);

        if ($paymentIntent->status === 'succeeded') {
            $reserva = Reserva::find($paymentIntent->metadata->reserva_id);
            $reserva->update([
                'pago_realizado' => true,
                'porcentaje_pagado' => 20
            ]);

            return true;
        }

        return false;
    }
}