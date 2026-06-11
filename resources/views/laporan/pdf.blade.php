<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Laporan Safitri Mart</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'DejaVu Sans', Arial, sans-serif;
      font-size: 11px;
      color: #1a1a1a;
    }

    /* Header */
    .header {
      background: #1B4D3E;
      color: #fff;
      padding: 18px 24px;
      margin-bottom: 20px;
      border-radius: 4px;
    }

    .header h1 {
      font-size: 20px;
      font-weight: 700;
      margin-bottom: 2px;
    }

    .header p {
      font-size: 11px;
      opacity: 0.85;
    }

    .header .periode {
      float: right;
      text-align: right;
      margin-top: -36px;
    }

    .header .periode span {
      font-size: 15px;
      font-weight: 700;
    }

    /* Summary Cards */
    .summary {
      display: table;
      width: 100%;
      margin-bottom: 20px;
      border-spacing: 8px;
    }

    .summary-card {
      display: table-cell;
      background: #f8f9fa;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      padding: 12px 14px;
      text-align: center;
      width: 16.66%;
    }

    .summary-card .label {
      font-size: 9px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #666;
      margin-bottom: 4px;
    }

    .summary-card .value {
      font-size: 16px;
      font-weight: 700;
      color: #1B4D3E;
    }

    .summary-card.highlight {
      background: #1B4D3E;
      border-color: #1B4D3E;
    }

    .summary-card.highlight .label {
      color: rgba(255, 255, 255, 0.75);
    }

    .summary-card.highlight .value {
      color: #fff;
    }

    /* Table */
    .section-title {
      font-size: 13px;
      font-weight: 700;
      color: #1B4D3E;
      border-bottom: 2px solid #1B4D3E;
      padding-bottom: 6px;
      margin-bottom: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    thead th {
      background: #1B4D3E;
      color: #fff;
      padding: 9px 10px;
      text-align: left;
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }

    tbody tr:nth-child(even) {
      background: #f0fdf4;
    }

    tbody tr:nth-child(odd) {
      background: #fff;
    }

    tbody td {
      padding: 8px 10px;
      border-bottom: 1px solid #e8f5e9;
      font-size: 10.5px;
      vertical-align: middle;
    }

    tfoot td {
      background: #e8f5e9;
      font-weight: 700;
      padding: 9px 10px;
      border-top: 2px solid #1B4D3E;
    }

    /* Status Badge */
    .badge {
      padding: 2px 8px;
      border-radius: 20px;
      font-size: 9px;
      font-weight: 600;
    }

    .badge-pending {
      background: #fef3c7;
      color: #92400e;
    }

    .badge-diproses {
      background: #dbeafe;
      color: #1e40af;
    }

    .badge-dikirim {
      background: #ede9fe;
      color: #5b21b6;
    }

    .badge-selesai {
      background: #d1fae5;
      color: #065f46;
    }

    .badge-dibatalkan {
      background: #fee2e2;
      color: #991b1b;
    }

    /* Footer */
    .footer {
      margin-top: 24px;
      border-top: 1px solid #ddd;
      padding-top: 10px;
      color: #888;
      font-size: 9px;
    }

    .footer .left {
      float: left;
    }

    .footer .right {
      float: right;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .green {
      color: #065f46;
      font-weight: 700;
    }

    .red {
      color: #991b1b;
    }
  </style>
</head>

<body>

  <!-- Header -->
  <div class="header">
    <h1>🛒 Safitri Mart — Laporan Transaksi</h1>
    <p>Dibuat otomatis pada {{ now()->format('d F Y, H:i') }} WIB</p>
    <div class="periode">
      <div style="font-size:10px;opacity:0.75;">Periode</div>
      <span>{{ $namaBulan }}</span>
    </div>
    <div style="clear:both;"></div>
  </div>

  <!-- Summary -->
  <div class="summary">
    <div class="summary-card highlight">
      <div class="label">Total Pendapatan</div>
      <div class="value" style="font-size:13px;">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</div>
    </div>
    <div class="summary-card">
      <div class="label">Total Transaksi</div>
      <div class="value">{{ $summary['total_transaksi'] }}</div>
    </div>
    <div class="summary-card">
      <div class="label">Total Diskon</div>
      <div class="value" style="color:#dc2626;">Rp {{ number_format($summary['total_diskon'], 0, ',', '.') }}</div>
    </div>
    <div class="summary-card">
      <div class="label">Selesai</div>
      <div class="value">{{ $summary['selesai'] }}</div>
    </div>
    <div class="summary-card">
      <div class="label">Pending</div>
      <div class="value" style="color:#d97706;">{{ $summary['pending'] }}</div>
    </div>
    <div class="summary-card">
      <div class="label">Dibatalkan</div>
      <div class="value" style="color:#dc2626;">{{ $summary['dibatalkan'] }}</div>
    </div>
  </div>

  <!-- Tabel Transaksi -->
  <div class="section-title">Detail Transaksi</div>
  <table>
    <thead>
      <tr>
        <th style="width:9%;">No. Transaksi</th>
        <th style="width:12%;">Tanggal</th>
        <th style="width:14%;">Pembeli</th>
        <th style="width:13%;">Email</th>
        <th style="width:10%;">Pembayaran</th>
        <th style="width:10%;">Voucher</th>
        <th style="width:9%;" class="text-right">Subtotal</th>
        <th style="width:9%;" class="text-right">Diskon</th>
        <th style="width:9%;" class="text-right">Total Bayar</th>
        <th style="width:5%;" class="text-center">Status</th>
      </tr>
    </thead>
    <tbody>
      @forelse($transaksi as $t)
            <tr>
              <td><strong>#TRX{{ str_pad($t->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
              <td>{{ $t->created_at->format('d M Y') }}</td>
              <td>{{ $t->nama_pembeli }}</td>
              <td style="font-size:9px;">{{ $t->user->email ?? '-' }}</td>
              <td>{{ match ($t->metode_pembayaran) {
          'cod' => 'COD', 'qris' => 'QRIS', 'dana' => 'DANA',
          'transfer_bank' => 'Transfer', default => $t->metode_pembayaran
        } }}</td>
              <td>{{ $t->voucher->kode ?? '-' }}</td>
              <td class="text-right">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
              <td class="text-right red">
                @if($t->diskon_voucher > 0)- Rp {{ number_format($t->diskon_voucher, 0, ',', '.') }}@else-@endif
              </td>
              <td class="text-right green">Rp {{ number_format($t->total_bayar ?? $t->total, 0, ',', '.') }}</td>
              <td class="text-center">
                <span class="badge badge-{{ $t->status }}">
                  {{ match ($t->status) {
          'pending' => 'Pending', 'diproses' => 'Diproses', 'dikirim' => 'Dikirim',
          'selesai' => 'Selesai', 'dibatalkan' => 'Batal', default => $t->status
        } }}
                </span>
              </td>
            </tr>
      @empty
        <tr>
          <td colspan="10" class="text-center" style="color:#888;">Tidak ada transaksi pada periode ini</td>
        </tr>
      @endforelse
    </tbody>
    <tfoot>
      <tr>
        <td colspan="6"><strong>TOTAL (Transaksi Selesai)</strong></td>
        <td class="text-right">Rp {{ number_format($transaksi->sum('total'), 0, ',', '.') }}</td>
        <td class="text-right red">- Rp {{ number_format($transaksi->sum('diskon_voucher'), 0, ',', '.') }}</td>
        <td class="text-right green">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</td>
        <td></td>
      </tr>
    </tfoot>
  </table>

  <!-- Footer -->
  <div class="footer">
    <div class="left">Safitri Mart &copy; {{ date('Y') }} — Dokumen ini digenerate otomatis oleh sistem</div>
    <div class="right">Laporan Periode: {{ $namaBulan }}</div>
    <div style="clear:both;"></div>
  </div>

</body>

</html>