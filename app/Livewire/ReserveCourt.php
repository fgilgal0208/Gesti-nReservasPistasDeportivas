<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Court;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReserveCourt extends Component
{
    // Variables enlazadas al formulario
    public $court_id = '';
    public $reservation_date = '';
    public $start_time = '';

    public function render()
    {
        return view('livewire.reserve-court', [
            'courts' => Court::where('is_active', true)->get()
        ]);
    }

    public function save()
    {
        // 1. Validación básica de los campos
        $this->validate([
            'court_id' => 'required|exists:courts,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
        ], [
            'reservation_date.after_or_equal' => 'No puedes reservar en el pasado.',
            'court_id.required' => 'Debes seleccionar una pista.',
        ]);

        // 2. Construcción de fechas con Carbon
        $startDateTime = Carbon::parse($this->reservation_date . ' ' . $this->start_time);
        $endDateTime = $startDateTime->copy()->addMinutes(90); // Partidos de 90 min estrictos

        // 3. Prevención de Overbooking (Solapamiento)
        $conflict = Reservation::where('court_id', $this->court_id)
            ->where('status', 'confirmed')
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                // Lógica de solapamiento
                $query->where('start_time', '<', $endDateTime)
                      ->where('end_time', '>', $startDateTime);
            })
            ->exists();

        if ($conflict) {
            // Mandamos el error personalizado a la vista
            $this->addError('overlap', '¡Esa pista ya está ocupada en ese tramo! El bloque de 90 min choca con otra reserva. Elige otra hora.');
            return;
        }

        // 4. Guardar la reserva en Base de Datos
        Reservation::create([
            'user_id' => Auth::id(),
            'court_id' => $this->court_id,
            'start_time' => $startDateTime,
            'end_time' => $endDateTime,
            'status' => 'confirmed',
        ]);

        // 5. Mensaje de éxito y limpieza del formulario
        session()->flash('message', '¡Reserva confirmada con éxito! Has reservado 90 minutos.');
        $this->reset(['court_id', 'reservation_date', 'start_time']);
    }
}