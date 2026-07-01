<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Menu Dessert</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #2b2230;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #d6336c;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            color: #d6336c;
        }
        .header p {
            margin: 2px 0;
            font-size: 10px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #d6336c;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #fdf2f6;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 20px;
            font-size: 9px;
            color: #777;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Data Menu Dessert</h2>
        <p>Manis Dessert House &mdash; Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Nama Dessert</th>
                <th>Kategori</th>
                <th>Komposisi</th>
                <th class="text-right">Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($desserts as $i => $dessert)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $dessert->id_dessert }}</td>
                    <td>{{ $dessert->nama_dessert }}</td>
                    <td>{{ $dessert->kategori }}</td>
                    <td>{{ $dessert->komposisi }}</td>
                    <td class="text-right">{{ number_format($dessert->harga, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Belum ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer">Total data: {{ $desserts->count() }} menu dessert</p>
</body>
</html>
