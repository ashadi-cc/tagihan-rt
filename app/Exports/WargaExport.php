<?php 


namespace App\Exports; 

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WargaExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return  User::warga()->orderBy('blok_name')->orderBy('blok_number')->get();
    }

    public function map($user): array
    {
        return [
            $user->blok, 
            $user->name,
            $user->email,
        ];
    }

    public function headings(): array
    {
        return [
            'Blok',
            'Nama',
            'Email',
        ];
    }

}