<?php

namespace App\Exports;

use App\Models\Reservation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReservationsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Reservation::with(['user', 'court'])->orderBy('start_time', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'ID Reserva',
            'Pista',
            'Usuario',
            'Día y Hora Inicio',
            'Día y Hora Fin',
            'Estado'
        ];
    }

    public function map($reservation): array
    {
        return [
            $reservation->id,
            $reservation->court->name,
            $reservation->user->name,
            $reservation->start_time->format('d/m/Y H:i'),
            $reservation->end_time->format('d/m/Y H:i'),
            $reservation->status,
        ];
    }
}