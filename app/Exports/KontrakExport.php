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
            $jenisKontrak = ($contract->jenis_kontrak == 1) ? 'Jaminan' : 'Tanpa Jaminan';
            return [
                    'Nomor SP' => $contract->detail_number,
                    'Tanggal SP' => date('d-m-Y', strtotime($contract->date_kontrak)),
                    'Nomor SOP' => $contract->nomor_sop,
                    'Tanggal SOP' => date('d-m-Y', strtotime($contract->tanggal_sop)),
                    'Perihal' => $contract->perihal,
                    'Pembuat' => $contract->pembuat,
                    'Unit Kerja' => $contract->unit_kerja,
                    'Jenis Kontrak' => $jenisKontrak,
                    'Status' => $contract->status,
                    'Nominal' => $contract->total_keseluruhan,
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
            'Perihal',
            'Pembuat',
            'Unit Kerja',
            'Jenis Kontrak',
            'Status',
            'Nominal'
        ];
    }
}
