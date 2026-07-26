<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::where('user_id', Auth::id())
            ->with('payments')
            ->orderBy('due_date')
            ->get();

        return view('bills.index', compact('bills'));
    }

    public function create()
    {
        return view('bills.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'due_date' => 'required|date',
        ]);

        Bill::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'status' => 'belum_lunas',
        ]);

        return redirect()->route('bills.index')->with('success', 'Tagihan berhasil ditambah!');
    }

    public function edit(Bill $bill)
    {
        return view('bills.edit', compact('bill'));
    }

    public function update(Request $request, Bill $bill)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'due_date' => 'required|date',
            'status' => 'required|in:belum_lunas,lunas',
        ]);

        $bill->update($request->only(['name', 'amount', 'due_date', 'status']));

        return redirect()->route('bills.index')->with('success', 'Tagihan diupdate!');
    }

    public function destroy(Bill $bill)
    {
        $bill->delete();
        return redirect()->route('bills.index')->with('success', 'Tagihan dihapus!');
    }

    public function pay(Request $request, Bill $bill)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $bill->remaining(),
        ]);

        BillPayment::create([
            'bill_id' => $bill->id,
            'amount' => $request->amount,
            'paid_at' => $request->paid_at ?? now()->format('Y-m-d'),
        ]);

        if ($bill->fresh()->remaining() <= 0) {
            $bill->update(['status' => 'lunas']);
        }

        return back()->with('success', 'Pembayaran berhasil!');
    }

    public function remind(Bill $bill)
    {
        Mail::raw(
            "Halo {$bill->user->name},\n\nTagihan '{$bill->name}' sebesar Rp " . number_format($bill->amount, 0, ',', '.') . " akan jatuh tempo pada " . \Carbon\Carbon::parse($bill->due_date)->isoFormat('D MMMM Y') . ". Jangan lupa dibayar ya!\n\n- RantauWallet",
            function ($message) use ($bill) {
                $message->to($bill->user->email)
                    ->subject("Pengingat: Tagihan {$bill->name} jatuh tempo!");
            }
        );

        return back()->with('success', 'Reminder terkirim ke ' . $bill->user->email);
    }
}