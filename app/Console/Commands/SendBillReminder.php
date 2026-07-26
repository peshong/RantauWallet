<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendBillReminder extends Command
{
    protected $signature = 'bills:remind';
    protected $description = 'Kirim email pengingat tagihan';

    public function handle()
    {
        $besok = Carbon::tomorrow()->format('Y-m-d');

        $bills = Bill::where('due_date', $besok)
            ->where('status', 'belum_lunas')
            ->with('user')
            ->get();

        foreach ($bills as $bill) {
            Mail::raw(
                "Halo {$bill->user->name},\n\nTagihan '{$bill->name}' sebesar Rp " . number_format($bill->amount, 0, ',', '.') . " akan jatuh tempo besok ({$bill->due_date}). Jangan lupa dibayar ya!\n\n- RantauWallet",
                function ($message) use ($bill) {
                    $message->to($bill->user->email)
                        ->subject("Pengingat: Tagihan {$bill->name} jatuh tempo besok!");
                }
            );
        }

        $this->info('Reminder sent for ' . $bills->count() . ' bills.');
    }
}