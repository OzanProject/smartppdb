<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
        }
        .school-name {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 0;
            color: #000;
        }
        .school-info {
            font-size: 10pt;
            margin-top: 5px;
        }
        .report-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 20px;
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000;
            padding: 8px;
        }
        td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: middle;
        }
        .text-center { text-align: center; }
        .text-uppercase { text-transform: uppercase; }
        .footer {
            margin-top: 30px;
            width: 100%;
        }
        .footer-date {
            text-align: right;
            font-style: italic;
            font-size: 8pt;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name">{{ strtoupper($school->name ?? ($landingSettings['app_name'] ?? 'PPDB PRO')) }}</div>
        <div class="school-info">
            @if($school->npsn) NPSN: {{ $school->npsn }} @endif
            @if($school->phone) | Telp: {{ $school->phone }} @endif
            @if($school->email) | Email: {{ $school->email }} @endif
            <br>
            {{ $school->address ?? '' }}
        </div>
    </div>

    <div class="report-title">{{ $title }}</div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">NO</th>
                <th style="width: 100px;">NO. REGISTRASI</th>
                <th>NAMA LENGKAP</th>
                <th style="width: 90px;">NISN</th>
                <th style="width: 150px;">GELOMBANG / TAHUN</th>
                <th style="width: 90px;">TGL TERIMA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $student->registration_number }}</td>
                <td class="text-uppercase">{{ $student->user->name ?? '-' }}</td>
                <td class="text-center">{{ $student->nisn ?? '-' }}</td>
                <td class="text-center">
                    {{ $student->admissionBatch->name ?? '-' }}
                    <br>
                    <small>{{ $student->admissionBatch->academicYear->name ?? '-' }}</small>
                </td>
                <td class="text-center">{{ $student->updated_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="footer-date">
            Dicetak secara otomatis oleh Sistem {{ $landingSettings['app_name'] ?? 'PPDB Online' }} pada: {{ date('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>
