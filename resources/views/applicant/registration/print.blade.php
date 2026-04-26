<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Kelulusan Pendaftaran - {{ $registration->registration_number }}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-color: #fff;
            color: #000;
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 10mm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header img {
            max-height: 80px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .data-table {
            width: 100%;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .data-table td {
            padding: 8px 4px;
            vertical-align: top;
        }
        .data-table td.label-col {
            width: 35%;
            font-weight: bold;
        }
        .data-table td.colon-col {
            width: 2%;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(0, 0, 0, 0.05);
            font-weight: bold;
            text-transform: uppercase;
            z-index: 0;
            pointer-events: none;
        }
        
        .content-wrapper {
            position: relative;
            z-index: 1;
        }

        .signatures {
            margin-top: 50px;
            width: 100%;
        }
        .signatures table {
            width: 100%;
            text-align: center;
            font-size: 14px;
        }
        .signatures .sign-space {
            height: 80px;
        }

        .footer-note {
            margin-top: 40px;
            font-size: 12px;
            font-style: italic;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }

        @media print {
            body {
                background-color: #fff;
            }
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
            .btn-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<div class="text-center mt-3 mb-3 btn-print">
    <button onclick="window.print()" class="btn btn-primary btn-lg"><i class="fas fa-print mr-2"></i> Cetak Dokumen</button>
    <button onclick="window.close()" class="btn btn-secondary btn-lg ml-2"><i class="fas fa-times mr-2"></i> Tutup</button>
</div>

<div class="page">
    <div class="watermark">DITERIMA</div>
    
    <div class="content-wrapper">
        <div class="header">
            <table width="100%">
                <tr>
                    <td width="15%" class="text-center">
                        @if(optional($registration->school)->logo)
                            <img src="{{ asset('storage/' . $registration->school->logo) }}" alt="Logo">
                        @else
                            <i class="fas fa-university fa-4x text-dark"></i>
                        @endif
                    </td>
                    <td width="85%" class="text-center">
                        <h2>{{ $registration->school->name ?? 'PPDB PRO SCHOOL' }}</h2>
                        <p>
                            <strong>PANITIA PENERIMAAN PESERTA DIDIK BARU (PPDB) TAHUN AJARAN {{ $registration->admissionBatch->academicYear->name ?? date('Y/Y', strtotime('+1 year')) }}</strong><br>
                            {{ $registration->school->address ?? 'Alamat Sekolah Belum Diatur' }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="title">SURAT BUKTI KELULUSAN PENDAFTARAN</div>

        <p class="text-justify mb-4">
            Berdasarkan hasil seleksi Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran {{ $registration->admissionBatch->academicYear->name ?? date('Y') }}, menyatakan bahwa pendaftar di bawah ini:
        </p>

        <table class="data-table">
            <tr>
                <td class="label-col">No. Registrasi</td>
                <td class="colon-col">:</td>
                <td style="font-weight: bold; font-size: 16px;">{{ $registration->registration_number }}</td>
            </tr>
            <tr>
                <td class="label-col">Nama Lengkap</td>
                <td class="colon-col">:</td>
                <td>{{ $registration->applicant_name }}</td>
            </tr>
            <tr>
                <td class="label-col">Tanggal Pendaftaran</td>
                <td class="colon-col">:</td>
                <td>{{ \Carbon\Carbon::parse($registration->created_at)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label-col">Gelombang Pendaftaran</td>
                <td class="colon-col">:</td>
                <td>{{ $registration->admissionBatch->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Status Kelulusan</td>
                <td class="colon-col">:</td>
                <td><span style="border: 2px solid #000; padding: 2px 10px; font-weight: bold; border-radius: 4px;">LULUS / DITERIMA</span></td>
            </tr>
        </table>

        <div style="border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; padding: 15px 0; margin-bottom: 20px;">
            <h5 style="margin-top: 0; font-weight: bold; font-size: 15px;">Catatan Tambahan (Berdasarkan Isian Formulir):</h5>
            <table class="data-table" style="margin-bottom: 0;">
                @if(isset($registration->personal_data['nik']) || isset($registration->personal_data['NIK']))
                <tr>
                    <td class="label-col" style="width: 35%;">NIK</td>
                    <td class="colon-col">:</td>
                    <td>{{ $registration->personal_data['nik'] ?? $registration->personal_data['NIK'] }}</td>
                </tr>
                @endif
                
                @if(isset($registration->previous_school_data['Nama Sekolah Asal']) || isset($registration->additional_data['Nama Sekolah Asal']))
                <tr>
                    <td class="label-col">Asal Sekolah</td>
                    <td class="colon-col">:</td>
                    <td>{{ $registration->previous_school_data['Nama Sekolah Asal'] ?? $registration->additional_data['Nama Sekolah Asal'] ?? '-' }}</td>
                </tr>
                @endif

                @if(isset($registration->additional_data['Jalur Pendaftaran']))
                <tr>
                    <td class="label-col">Jalur Pendaftaran</td>
                    <td class="colon-col">:</td>
                    <td>{{ $registration->additional_data['Jalur Pendaftaran'] }}</td>
                </tr>
                @endif
            </table>
        </div>

        <p class="text-justify mt-4">
            Demikian surat bukti kelulusan ini dicetak untuk dapat dipergunakan sebagaimana mestinya sebagai salah satu syarat untuk melakukan daftar ulang. Harap membawa dokumen asli (Kartu Keluarga, Akta Kelahiran, Ijazah/SKHUN) saat melakukan daftar ulang ke sekolah.
        </p>

        <div class="signatures">
            <table>
                <tr>
                    <td width="50%">
                        <br>
                        Tanda Tangan Pendaftar / Orang Tua
                        <div class="sign-space"></div>
                        (......................................................)
                    </td>
                    <td width="50%">
                        {{ date('d F Y') }}<br>
                        Panitia PPDB,
                        <div class="sign-space"></div>
                        (......................................................)
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer-note">
            Dokumen ini dicetak secara otomatis dari Sistem {{ $landingSettings['app_name'] ?? 'PPDB PRO' }} pada {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}.<br>
            <i>Harap simpan dokumen ini dengan baik.</i>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        // Uncomment the line below to automatically print when opened
        window.print();
    }
</script>
</body>
</html>
