<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $subscription->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #fff; color: #333; font-size: 14px; }
        .invoice-container { max-width: 800px; margin: 0 auto; padding: 40px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 3px solid #007bff; }
        .header-left h1 { font-size: 28px; color: #007bff; font-weight: 800; letter-spacing: 2px; }
        .header-left p { color: #666; font-size: 12px; margin-top: 4px; }
        .header-right { text-align: right; }
        .header-right .invoice-number { font-size: 13px; color: #666; }
        .header-right .invoice-number code { font-size: 16px; font-weight: bold; color: #333; }
        .status-badge { display: inline-block; padding: 6px 16px; border-radius: 20px; font-weight: bold; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-top: 8px; }
        .status-active { background: #d4edda; color: #155724; }
        .status-pending_payment { background: #fff3cd; color: #856404; }
        .status-paid { background: #cce5ff; color: #004085; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .status-expired { background: #e2e3e5; color: #383d41; }
        .billing-section { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .billing-box { width: 48%; }
        .billing-box h3 { font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #999; margin-bottom: 10px; font-weight: 600; }
        .billing-box p { line-height: 1.6; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items-table th { background: #f8f9fa; padding: 12px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #666; border-bottom: 2px solid #dee2e6; }
        .items-table td { padding: 16px; border-bottom: 1px solid #eee; }
        .items-table .total-row td { border-top: 2px solid #333; border-bottom: none; font-weight: bold; font-size: 18px; }
        .items-table .total-label { text-align: right; }
        .items-table .total-amount { text-align: right; color: #007bff; }
        .bank-info { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; padding: 20px; margin-bottom: 30px; }
        .bank-info h3 { font-size: 14px; margin-bottom: 12px; color: #333; }
        .bank-info table { width: 100%; }
        .bank-info table td { padding: 4px 0; }
        .bank-info table td:first-child { width: 130px; font-weight: bold; color: #555; }
        .bank-info .account-number { font-size: 20px; font-weight: bold; color: #007bff; font-family: monospace; letter-spacing: 2px; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; text-align: center; color: #999; font-size: 11px; }
        .period-info { background: #d4edda; border-radius: 8px; padding: 15px 20px; margin-bottom: 20px; }
        .period-info strong { color: #155724; }
        .no-print { margin: 20px auto; max-width: 800px; text-align: center; }
        .no-print button { padding: 12px 40px; background: #007bff; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: bold; cursor: pointer; margin: 0 5px; }
        .no-print button:hover { background: #0056b3; }
        .no-print a { padding: 12px 40px; background: #6c757d; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-block; margin: 0 5px; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
            .invoice-container { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()"><i class="fas fa-print"></i> 🖨️ Cetak / Simpan PDF</button>
        <a href="javascript:history.back()">← Kembali</a>
    </div>

    <div class="invoice-container">
        {{-- Header --}}
        <div class="header">
            <div class="header-left">
                <h1>INVOICE</h1>
                <p>Sistem PPDB Pro — Manajemen Langganan</p>
            </div>
            <div class="header-right">
                <div class="invoice-number">
                    No. Invoice:<br>
                    <code>{{ $subscription->invoice_number }}</code>
                </div>
                <div class="status-badge status-{{ $subscription->status }}">
                    {{ $subscription->status_label }}
                </div>
            </div>
        </div>

        {{-- Billing Section --}}
        <div class="billing-section">
            <div class="billing-box">
                <h3>Ditagihkan Kepada</h3>
                <p>
                    <strong>{{ $subscription->school->name }}</strong><br>
                    {{ $subscription->school->email }}<br>
                    {{ $subscription->school->phone }}<br>
                    {{ $subscription->school->address }}
                </p>
            </div>
            <div class="billing-box" style="text-align: right;">
                <h3>Detail Invoice</h3>
                <p>
                    <strong>Tanggal:</strong> {{ $subscription->created_at->format('d M Y') }}<br>
                    <strong>Metode:</strong> {{ $subscription->payment_method == 'manual_transfer' ? 'Transfer Bank' : 'Payment Gateway' }}<br>
                    @if($subscription->paid_at)
                    <strong>Dibayar:</strong> {{ $subscription->paid_at->format('d M Y H:i') }}<br>
                    @endif
                </p>
            </div>
        </div>

        {{-- Items Table --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th style="text-align: center;">Periode</th>
                    <th style="text-align: center;">Kuota</th>
                    <th style="text-align: right;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Paket {{ $subscription->pricingPlan->name }}</strong><br>
                        <span style="color: #666; font-size: 12px;">{{ $subscription->pricingPlan->description }}</span>
                    </td>
                    <td style="text-align: center;">
                        @if($subscription->pricingPlan->billing_cycle == 'monthly') 1 Bulan
                        @elseif($subscription->pricingPlan->billing_cycle == 'yearly') 1 Tahun
                        @else Sekali Bayar
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $subscription->pricingPlan->max_quota == -1 ? 'Unlimited' : $subscription->pricingPlan->max_quota . ' Pendaftar' }}</td>
                    <td style="text-align: right;">Rp {{ number_format($subscription->amount, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" class="total-label">TOTAL</td>
                    <td class="total-amount">Rp {{ number_format($subscription->amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Bank Info --}}
        @if($subscription->payment_method == 'manual_transfer' && in_array($subscription->status, ['pending_payment']))
        <div class="bank-info">
            <h3>🏦 Informasi Rekening Transfer</h3>
            <table>
                <tr><td>Bank</td><td>: {{ $paymentSettings['bank_name'] ?? '-' }}</td></tr>
                <tr><td>No. Rekening</td><td>: <span class="account-number">{{ $paymentSettings['bank_account_number'] ?? '-' }}</span></td></tr>
                <tr><td>Atas Nama</td><td>: {{ $paymentSettings['bank_account_name'] ?? '-' }}</td></tr>
            </table>
            @if(!empty($paymentSettings['payment_instructions']))
            <hr style="margin: 12px 0; border: none; border-top: 1px solid #dee2e6;">
            <p style="color: #666; font-size: 12px; white-space: pre-line;">{{ $paymentSettings['payment_instructions'] }}</p>
            @endif
        </div>
        @endif

        {{-- Active Period --}}
        @if($subscription->status == 'active')
        <div class="period-info">
            <strong>✅ Periode Aktif:</strong> {{ $subscription->starts_at?->format('d M Y') }} — {{ $subscription->ends_at?->format('d M Y') }}
        </div>
        @endif

        {{-- Footer --}}
        <div class="footer">
            <p>Invoice ini dicetak secara otomatis oleh sistem PPDB Pro.</p>
            <p>Tanggal cetak: {{ now()->format('d M Y H:i') }} WIB</p>
        </div>
    </div>
</body>
</html>
