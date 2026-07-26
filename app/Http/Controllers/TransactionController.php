<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())->with('category')->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'type' => 'required|in:pemasukan,pengeluaran,transfer',
            'source' => 'required|in:cash,bank',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
            'to_source' => 'nullable|in:cash,bank',
        ]);

        $amount = $request->amount;

        // Cek saldo untuk pengeluaran & transfer
        if (in_array($request->type, ['pengeluaran', 'transfer'])) {
            $userTransactions = Transaction::where('user_id', Auth::id())->get();

            $pemasukanSource = $userTransactions->where('type', 'pemasukan')->where('source', $request->source)->sum('amount');
            $pengeluaranSource = $userTransactions->where('type', 'pengeluaran')->where('source', $request->source)->sum('amount');
            $transferKeluar = $userTransactions->where('type', 'transfer')->where('source', $request->source)->sum('amount');
            $transferMasuk = $userTransactions->where('type', 'transfer')->where('to_source', $request->source)->sum('amount');
            $saldoSource = $pemasukanSource + $transferMasuk - $pengeluaranSource - $transferKeluar;

            if ($saldoSource < $amount) {
                $namaSource = $request->source == 'cash' ? 'Cash' : 'Rekening';
                return back()->withErrors([
                    'amount' => 'Saldo ' . $namaSource . ' tidak mencukupi!'
                ])->withInput();
            }
        }

        // Jika transfer, category_id harus null
        if ($request->type == 'transfer') {
            Transaction::create([
                'user_id' => Auth::id(),
                'category_id' => null,
                'type' => 'transfer',
                'source' => $request->source,
                'to_source' => $request->to_source,
                'amount' => $amount,
                'description' => $request->description,
                'date' => $request->date,
            ]);
        } else {
            Transaction::create([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'type' => $request->type,
                'source' => $request->source,
                'amount' => $amount,
                'description' => $request->description,
                'date' => $request->date,
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil!');
    }

    public function edit(Transaction $transaction)
    {
        $categories = Category::all();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'type' => 'required|in:pemasukan,pengeluaran,transfer',
            'source' => 'required|in:cash,bank',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
            'to_source' => 'nullable|in:cash,bank',
        ]);

        $data = [
            'category_id' => $request->type == 'transfer' ? null : $request->category_id,
            'type' => $request->type,
            'source' => $request->source,
            'to_source' => $request->type == 'transfer' ? $request->to_source : null,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
        ];

        $transaction->update($data);
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diupdate!');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}