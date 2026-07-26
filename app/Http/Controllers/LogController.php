<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LogController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('category')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $pemasukanCash = $transactions->where('type', 'pemasukan')->where('source', 'cash')->sum('amount');
        $pengeluaranCash = $transactions->where('type', 'pengeluaran')->where('source', 'cash')->sum('amount');
        $transferKeluarCash = $transactions->where('type', 'transfer')->where('source', 'cash')->sum('amount');
        $transferMasukCash = $transactions->where('type', 'transfer')->where('to_source', 'cash')->sum('amount');
        $saldoCash = $pemasukanCash + $transferMasukCash - $pengeluaranCash - $transferKeluarCash;

        $pemasukanBank = $transactions->where('type', 'pemasukan')->where('source', 'bank')->sum('amount');
        $pengeluaranBank = $transactions->where('type', 'pengeluaran')->where('source', 'bank')->sum('amount');
        $transferKeluarBank = $transactions->where('type', 'transfer')->where('source', 'bank')->sum('amount');
        $transferMasukBank = $transactions->where('type', 'transfer')->where('to_source', 'bank')->sum('amount');
        $saldoBank = $pemasukanBank + $transferMasukBank - $pengeluaranBank - $transferKeluarBank;

        $saldoTotal = $saldoCash + $saldoBank;

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth()->format('Y-m-d');
        $endOfMonth = $now->copy()->endOfMonth()->format('Y-m-d');
        $endOfMonthObj = $now->copy()->endOfMonth();

        $totalPengeluaranBulanIni = Transaction::where('user_id', Auth::id())
            ->where('type', 'pengeluaran')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $hariIni = $now->day;
        $rataRataHarian = $hariIni > 0 ? $totalPengeluaranBulanIni / $hariIni : 0;
        $prediksiHariTersisa = $rataRataHarian > 0 ? floor($saldoTotal / $rataRataHarian) : null;

        // Batasi maksimal sampai akhir bulan
        $hariTersisaBulanIni = $now->diffInDays($endOfMonthObj) + 1;
        if ($prediksiHariTersisa && $prediksiHariTersisa > $hariTersisaBulanIni) {
            $prediksiHariTersisa = $hariTersisaBulanIni;
        }

        $prediksiTanggalHabis = $prediksiHariTersisa ? $now->copy()->addDays($prediksiHariTersisa)->format('d F Y') : null;

        $groupedTransactions = $transactions->groupBy(function($item) {
            return Carbon::parse($item->date)->format('Y-m');
        });

        return view('log.index', compact(
            'groupedTransactions', 'saldoTotal', 'saldoCash', 'saldoBank',
            'rataRataHarian', 'prediksiTanggalHabis'
        ));
    }
}