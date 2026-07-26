<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->isoFormat('MMMM Y') }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { color: #2563eb; margin-bottom: 5px; }
        .summary { display: flex; justify-content: space-around; margin-bottom: 20px; }
        .summary div { text-align: center; padding: 10px 20px; border-radius: 10px; }
        .summary .in { background: #dcfce7; color: #16a34a; }
        .summary .out { background: #fee2e2; color: #dc2626; }
        .summary .total { background: #dbeafe; color: #2563eb; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #f3f4f6; padding: 10px; text-align: left; font-size: 12px; }
        td { padding: 10px; border-bottom: 1px solid #e5e7eb; font-size: 13px; }
        .footer { text-align: center; margin-top: 30px; font-size: 11px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="header">
        <h1>💸 RantauWallet</h1>
        <p>Laporan Keuangan Bulan {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->isoFormat('MMMM Y') }}</p>
    </div>

    <div class="summary">
        <div class="in">
            <p>Pemasukan</p>
            <h3>+Rp {{ number_format($pemasukan, 0, ',', '.') }}</h3>
        </div>
        <div class="out">
            <p>Pengeluaran</p>
            <h3>-Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
        </div>
        <div class="total">
            <p>Total</p>
            <h3>Rp {{ number_format($total, 0, ',', '.') }}</h3>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Tipe</th>
                <th>Sumber</th>
                <th>Jumlah</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $trx)
            <tr>
                <td>{{ \Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}</td>
                <td>{{ $trx->category->name ?? 'Transfer' }}</td>
                <td>{{ ucfirst($trx->type) }}</td>
                <td>{{ $trx->source == 'cash' ? 'Cash' : 'Rekening' }}</td>
                <td>Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                <td>{{ $trx->description ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }} • RantauWallet
    </div>
</body>
</html>