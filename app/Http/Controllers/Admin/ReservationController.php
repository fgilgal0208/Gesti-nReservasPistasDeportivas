<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReservationsExport;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['user', 'court'])->orderBy('start_time', 'asc')->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function exportPdf()
    {
        $reservations = Reservation::with(['user', 'court'])->orderBy('start_time', 'asc')->get();
        $pdf = Pdf::loadView('admin.reservations.pdf', compact('reservations'));
        return $pdf->download('cuadrante_pistas_muriano_'.date('Y-m-d').'.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ReservationsExport, 'reservas_muriano_'.date('Y-m-d').'.xlsx');
    }
}