<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Aplikasi Bergabung - UCB</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1e293b;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #6366f1;
        }
        .header h1 {
            font-size: 24px;
            color: #6366f1;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 14px;
            color: #64748b;
        }
        .info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f1f5f9;
            border-radius: 5px;
        }
        .info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #6366f1;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }
        .status-read {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-unread {
            background-color: #fef3c7;
            color: #92400e;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            font-size: 10px;
            color: #64748b;
        }
        .text-center {
            text-align: center;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Aplikasi Bergabung</h1>
        <p>Unceasing Cantica Bandung</p>
        <p>Tanggal Export: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <div class="info">
        <p><strong>Total Aplikasi:</strong> {{ $applications->count() }}</p>
        <p><strong>Filter:</strong> 
            @if($filter === 'all')
                Semua
            @elseif($filter === 'read')
                Sudah Dibaca
            @else
                Belum Dibaca
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Nama</th>
                <th style="width: 15%;">Email</th>
                <th style="width: 12%;">No. HP</th>
                <th style="width: 10%;">Part Suara</th>
                <th style="width: 15%;">Pengalaman</th>
                <th style="width: 13%;">Alasan</th>
                <th style="width: 8%;">Status</th>
                <th style="width: 7%;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $index => $application)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $application->name }}</td>
                    <td>{{ $application->email }}</td>
                    <td>{{ $application->phone }}</td>
                    <td>{{ $application->voice_part ?? '-' }}</td>
                    <td>{{ Str::limit($application->experience ?? '-', 50) }}</td>
                    <td>{{ Str::limit($application->reason ?? '-', 50) }}</td>
                    <td>
                        <span class="status-badge {{ $application->is_read ? 'status-read' : 'status-unread' }}">
                            {{ $application->is_read ? 'Dibaca' : 'Baru' }}
                        </span>
                    </td>
                    <td>{{ date('d/m/Y', strtotime($application->created_at)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 20px;">
                        Tidak ada data aplikasi
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dihasilkan secara otomatis oleh sistem CMS UCB</p>
        <p>© {{ date('Y') }} Unceasing Cantica Bandung. All rights reserved.</p>
    </div>
</body>
</html>

