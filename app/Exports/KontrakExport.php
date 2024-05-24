<?php

namespace App\Exports;

use App\Models\Kontrak;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class KontrakExport implements FromCollection, WithHeadings
{

    protected $contracts;

    public function __construct(Collection $contracts)
    {
        $this->contracts = $contracts;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return Kontrak::all();
        // return $this->contracts;
        return $this->contracts->map(function ($contract) {
            // Manipulasi nilai unit kerja
            $unitKerja = $contract->unit_kerja;
            switch ($unitKerja) {
                case '41A10':
                    $unitKerja = 'Investasi';
                    break;
                case '41A20':
                    $unitKerja = 'Jasa Barum';
                    break;
                case '41A30':
                    $unitKerja = 'Lokal';
                    break;
                case '41A40':
                    $unitKerja = 'Import';
                    break;
                default:
                    // Tidak ada manipulasi jika unit kerja tidak cocok dengan nilai yang diharapkan
                    break;
            }

            // manipulasi nilai jenis kontrak
            $jeniKontrak = ($contract->jenis_kontrak == 1) ? 'Lumpsum' : 'Harga Biasa';


            // manipulasi nilai status jaminan
            $statusJaminan = ($contract->status_jaminan == 1) ? 'Jaminan' : 'Tanpa Jaminan';

            return [
                'Nomor SP'                     => $contract->detail_number,
                'Tanggal SP'                   => date('d-m-Y', strtotime($contract->date_kontrak)),
                'Nomor SOP'                    => $contract->nomor_sop,
                'Tanggal SOP'                  => date('d-m-Y', strtotime($contract->tanggal_sop)),
                'Nama Vendor'                  => $contract->nm_vendor,
                'Perihal'                      => $contract->perihal,
                'Pembuat'                      => $contract->pembuat,
                'Unit Kerja'                   => $unitKerja,
                'Jenis Kontrak'                => $jeniKontrak,
                'Status Jaminan'               => $statusJaminan,
                'Total Nilai Harga (Incl PPN)' => @formatRupiah($contract->total_keseluruhan),
                'Status'                       => $contract->status,

            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nomor SP',
            'Tanggal SP',
            'Nomor SOP',
            'Tanggal SOP',
            'Nama Vendor',
            'Perihal',
            'Pembuat',
            'Unit Kerja',
            'Jenis Kontrak',
            'Status Jaminan',
            'Total Nilai Harga (Incl PPN)',
            'Status'

        ];
    }
}
