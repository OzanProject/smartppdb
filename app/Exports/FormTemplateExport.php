<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FormTemplateExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'bagian',
            'label_kolom',
            'keterangan',
            'tipe',
            'wajib',
            'opsi'
        ];
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return [
            [
                'Data Pribadi', 
                'Nama Lengkap', 
                'Sesuai Ijazah terakhir', 
                'text', 
                'Y', 
                ''
            ],
            [
                'Data Pribadi', 
                'Jenis Kelamin', 
                '', 
                'select', 
                'Y', 
                'Laki-laki, Perempuan'
            ],
            [
                'Data Pribadi', 
                'Tanggal Lahir', 
                '', 
                'date', 
                'Y', 
                ''
            ],
            [
                'Data Orang Tua', 
                'Nama Ayah Kandung', 
                '', 
                'text', 
                'Y', 
                ''
            ],
            [
                'Data Orang Tua', 
                'Pekerjaan Ayah', 
                '', 
                'select', 
                'N', 
                'PNS, TNI/POLRI, Swasta, Buruh, Lainnya'
            ],
            [
                'Data Periodik', 
                'Tinggi Badan (cm)', 
                'Hanya masukkan angka', 
                'number', 
                'N', 
                ''
            ],
            [
                'Pernyataan', 
                'Alasan Mendaftar', 
                'Ceritakan motivasi Anda masuk sekolah ini', 
                'textarea', 
                'Y', 
                ''
            ],
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Template Form PPDB';
    }
}
