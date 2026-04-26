<table>
    <thead>
        <!-- Header Kop Surat -->
        <tr>
            <th colspan="6" style="text-align: center; font-weight: bold; font-size: 16pt;">
                {{ strtoupper($school->name ?? 'PPDB PRO') }}
            </th>
        </tr>
        @if($school->npsn)
        <tr>
            <th colspan="6" style="text-align: center; font-weight: bold; font-size: 12pt;">
                NPSN: {{ $school->npsn }}
            </th>
        </tr>
        @endif
        @if($school->address)
        <tr>
            <th colspan="6" style="text-align: center; font-size: 10pt;">
                {{ $school->address }}
            </th>
        </tr>
        @endif
        <tr>
            <th colspan="6" style="text-align: center; border-bottom: 2px solid #000;"></th>
        </tr>
        <tr><th colspan="6"></th></tr> <!-- Spacer -->
        <tr>
            <th colspan="6" style="text-align: center; font-weight: bold; font-size: 14pt;">
                {{ $title }}
            </th>
        </tr>
        <tr><th colspan="6"></th></tr> <!-- Spacer -->
        
        <!-- Table Headings -->
        <tr>
            <th style="background-color: #f2f2f2; border: 1px solid #000; font-weight: bold; text-align: center; width: 50px;">NO</th>
            <th style="background-color: #f2f2f2; border: 1px solid #000; font-weight: bold; text-align: center; width: 150px;">NO. REGISTRASI</th>
            <th style="background-color: #f2f2f2; border: 1px solid #000; font-weight: bold; text-align: center; width: 250px;">NAMA LENGKAP</th>
            <th style="background-color: #f2f2f2; border: 1px solid #000; font-weight: bold; text-align: center; width: 120px;">NISN</th>
            <th style="background-color: #f2f2f2; border: 1px solid #000; font-weight: bold; text-align: center; width: 200px;">GELOMBANG / TAHUN</th>
            <th style="background-color: #f2f2f2; border: 1px solid #000; font-weight: bold; text-align: center; width: 150px;">TGL DITERIMA</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $index => $student)
        <tr>
            <td style="border: 1px solid #000; text-align: center;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $student->registration_number }}</td>
            <td style="border: 1px solid #000;">{{ strtoupper($student->user->name ?? '-') }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $student->nisn ?? '-' }}</td>
            <td style="border: 1px solid #000; text-align: center;">
                {{ $student->admissionBatch->name ?? '-' }} / {{ $student->admissionBatch->academicYear->name ?? '-' }}
            </td>
            <td style="border: 1px solid #000; text-align: center;">{{ $student->updated_at->format('d/m/Y') }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr><th colspan="6"></th></tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="2" style="text-align: center;">
                Dicetak pada: {{ date('d F Y H:i') }}
            </td>
        </tr>
    </tfoot>
</table>
