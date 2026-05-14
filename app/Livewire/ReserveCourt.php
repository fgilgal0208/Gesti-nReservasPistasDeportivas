<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Court;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReserveCourt extends Component
{
    public $weekOffset = 0;
    public $court_id = 1; // Controla lo que muestra la tabla
    
    // Datos del formulario de reserva
    public $selected_court_id = 1; // El usuario elige aquí la pista final
    public $reservation_date;
    public $start_time;

    public function getSlotsProperty()
    {
        $slots = [];
        $current = Carbon::createFromTime(8, 30);
        $end = Carbon::createFromTime(22, 0);
        
        while ($current < $end) {
            $slots[] = $current->format('H:i');
            $current->addMinutes(30);
        }
        return $slots;
    }

    public function changeWeek($direction)
    {
        $newOffset = $this->weekOffset + $direction;
        if ($newOffset >= 0 && $newOffset <= 4) $this->weekOffset = $newOffset;
    }

    public function save()
    {
        $this->validate([
            'selected_court_id' => 'required|exists:courts,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
        ]);

        $start = Carbon::parse($this->reservation_date . ' ' . $this->start_time);
        $end = $start->copy()->addMinutes(90);

        if ($end->format('H:i') > '22:00' || $start->format('H:i') < '08:30') {
            $this->addError('start_time', 'El horario debe estar entre las 08:30 y las 22:00.');
            return;
        }

        $conflict = Reservation::where('court_id', $this->selected_court_id)
            ->where('status', 'confirmed')
            ->where('start_time', '<', $end)
            ->where('end_time', '>', $start)
            ->exists();

        if ($conflict) {
            $this->addError('overlap', 'La pista elegida ya tiene una reserva en ese horario.');
            return;
        }

        Reservation::create([
            'user_id' => Auth::id(),
            'court_id' => $this->selected_court_id,
            'start_time' => $start,
            'end_time' => $end,
            'status' => 'confirmed'
        ]);

        session()->flash('message', '¡Reserva confirmada con éxito!');
        $this->reset(['reservation_date', 'start_time']);
    }

    public function render()
    {
        Carbon::setLocale('es');
        
        // Calculamos el lunes de la semana que toque según el offset
        $startOfWeek = Carbon::now()->startOfWeek()->addWeeks($this->weekOffset);
        $endOfWeek = $startOfWeek->copy()->endOfWeek();
        
        $days = [];
        for ($i = 0; $i < 7; $i++) { 
            $days[] = $startOfWeek->copy()->addDays($i); 
        }

        $reservations = Reservation::where('court_id', $this->court_id)
            ->where('status', 'confirmed')
            ->whereBetween('start_time', [$startOfWeek->startOfDay(), $endOfWeek->endOfDay()])
            ->get();

        return view('livewire.reserve-court', [
            'courts' => Court::all(),
            'days' => $days,
            'weekRange' => $startOfWeek->format('d M') . ' — ' . $endOfWeek->format('d M'),
            'existingReservations' => $reservations
        ]);
    }
}