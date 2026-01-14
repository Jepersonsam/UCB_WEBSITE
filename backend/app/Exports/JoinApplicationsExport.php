<?php

namespace App\Exports;

use App\Models\JoinApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JoinApplicationsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $filter;

    public function __construct($filter = 'all')
    {
        $this->filter = $filter;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = JoinApplication::latest();

        // Filter by read status
        if ($this->filter === 'unread') {
            $query->where('is_read', false);
        } elseif ($this->filter === 'read') {
            $query->where('is_read', true);
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'No. HP / WhatsApp',
            'Part Suara yang Diinginkan',
            'Pengalaman Bernyanyi',
            'Alasan Bergabung',
            'Status',
            'Tanggal Dibaca',
            'Tanggal Daftar',
        ];
    }

    /**
     * @param JoinApplication $application
     * @return array
     */
    public function map($application): array
    {
        return [
            $application->id,
            $application->name,
            $application->email,
            $application->phone,
            $application->voice_part ?? '-',
            $application->experience ?? '-',
            $application->reason ?? '-',
            $application->is_read ? 'Sudah Dibaca' : 'Belum Dibaca',
            $application->read_at ? date('d/m/Y H:i', strtotime($application->read_at)) : '-',
            date('d/m/Y H:i', strtotime($application->created_at)),
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E0E7FF']
            ]],
        ];
    }
}

