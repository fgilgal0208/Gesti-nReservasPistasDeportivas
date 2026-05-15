<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Court;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentReceiptMail;

class ReserveCourt extends Component
{
    use WithFileUploads;

    // Variables de Reserva
    public $court_id;
    public $selected_court_id;
    public $reservation_date;
    public $start_time;
    public $weekOffset = 0;
    public $currentReservationIndex = 0;

    // Variables de Justificante
    public $justificante;

    public function mount()
    {
        $firstCourt = Court::first();
        $this->court_id = $firstCourt?->id;
        $this->selected_court_id = $firstCourt?->id;
        $this->reservation_date = Carbon::today()->format('Y-m-d');
    }

    public function changeWeek($offset)
    {
        $this->weekOffset += $offset;
        $this->currentReservationIndex = 0;
    }

    public function nextReservation($total)
    {
        if ($this->currentReservationIndex < $total - 1) $this->currentReservationIndex++;
    }

    public function prevReservation()
    {
        if ($this->currentReservationIndex > 0) $this->currentReservationIndex--;
    }

    public function cancelReservation($id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->first();
        if ($reservation && $reservation->start_time > now()) {
            $reservation->delete();
            session()->flash('message', 'Reserva anulada correctamente.');
            $this->currentReservationIndex = 0;
        }
    }

    public function uploadReceipt()
    {
        // CAMBIO: Ahora validamos hasta 10240 KB (10MB)
        $this->validate([
            'justificante' => 'required|image|max:10240'
        ]);

        try {
            $path = $this->justificante->store('justificantes', 'local');
            $fullPath = storage_path('app/private/' . $path);

            Mail::to('frangilarte07@gmail.com')->send(
                new PaymentReceiptMail(auth()->user()->name, $fullPath)
            );

            $this->reset('justificante');
            session()->flash('message', 'Justificante enviado al Ayuntamiento (10MB máx).');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al enviar el correo.');
        }
    }

    public function save()
    {
        $this->validate([
            'selected_court_id' => 'required|exists:courts,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
        ]);

        $start = Carbon::parse($this->reservation_date . ' ' . $this->start_time);
        $end = (clone $start)->addMinutes(90);

        $overlap = Reservation::where('court_id', $this->selected_court_id)
            ->where(function ($query) use ($start, $end) {
                $query->where('start_time', '<', $end)->where('end_time', '>', $start);
            })->exists();

        if ($overlap) {
            $this->addError('overlap', 'Horario ocupado.');
            return;
        }

        $paymentCode = 'MUR-' . strtoupper(bin2hex(random_bytes(3)));

        Reservation::create([
            'user_id' => Auth::id(),
            'court_id' => $this->selected_court_id,
            'start_time' => $start,
            'end_time' => $end,
            'payment_code' => $paymentCode,
            'payment_status' => 'unpaid',
        ]);

        session()->flash('message', "Reserva realizada. Código: $paymentCode");
        $this->reset(['start_time']);
    }

    public function getSlotsProperty()
    {
        $slots = [];
        $start = Carbon::createFromTime(9, 0);
        $end = Carbon::createFromTime(22, 0);
        while ($start <= $end) {
            $slots[] = $start->format('H:i');
            $start->addMinutes(30);
        }
        return $slots;
    }

    public function getAvailableSlotsProperty()
    {
        $availableSlots = [];
        $reservationsOnDate = Reservation::where('court_id', $this->selected_court_id)
            ->whereDate('start_time', $this->reservation_date)->get();

        foreach ($this->slots as $slot) {
            $start = Carbon::parse($this->reservation_date . ' ' . $slot);
            $end = (clone $start)->addMinutes(90);
            if ($end > Carbon::parse($this->reservation_date . ' 22:00:00') || $start->isPast()) continue;

            $overlap = $reservationsOnDate->contains(fn($res) => $start < $res->end_time && $end > $res->start_time);
            if (!$overlap) $availableSlots[] = $slot;
        }
        return $availableSlots;
    }

    public function render()
    {
        $startOfWeek = Carbon::now()->startOfWeek()->addWeeks($this->weekOffset);
        $days = [];
        for ($i = 0; $i < 7; $i++) { $days[] = (clone $startOfWeek)->addDays($i); }

        $existingReservations = Reservation::where('court_id', $this->court_id)
            ->whereBetween('start_time', [$days[0]->startOfDay(), $days[6]->endOfDay()])->get();

        $upcomingReservations = Reservation::with('court')->where('user_id', Auth::id())
            ->where('start_time', '>=', now())->orderBy('start_time', 'asc')->get();

        return view('livewire.reserve-court', [
            'courts' => Court::all(),
            'days' => $days,
            'existingReservations' => $existingReservations,
            'upcomingReservations' => $upcomingReservations,
            'weekRange' => $days[0]->format('d M') . ' - ' . $days[6]->format('d M'),
        ]);
    }
}