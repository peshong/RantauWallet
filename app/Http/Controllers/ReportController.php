<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    

    public function download(Request $request)
{
    $month = $request->month ?? Carbon::now()->format('Y-m');
    $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
    $end = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

    $transactions = Transaction::where('user_id', Auth::id())
        ->with('category')
        ->whereBetween('date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
        ->orderBy('date', 'asc')
        ->get();

    $pemasukan = $transactions->where('type', 'pemasukan')->sum('amount');
    $pengeluaran = $transactions->where('type', 'pengeluaran')->sum('amount');
    $total = $pemasukan - $pengeluaran;

    $pdf = Pdf::loadView('report.pdf', compact(
        'transactions', 'month', 'pemasukan', 'pengeluaran', 'total'
    ));

    return $pdf->download('Laporan_' . $month . '.pdf');
}
}