<?php 

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Rules\ExcelFile;

trait Util 
{
    public function validateExcelFile(Request $request)
    {
        $request->validate([
            //'xls_file' => 'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xls_file' => [
                'required',
                'file',
                new ExcelFile()
            ]
        ]);
    }

    public function getFilterYearandMonth()
    {
        $startYear = 2015; 
        $endYear = intval(date('Y'));

        $years = []; 
        for ($i = $startYear; $i <= $endYear; $i++ )
        {
            $years[] = $i; 
        }

        $currentMonth = intval(date('n'));
        
        return [
            'years' => $years, 
            'year' => $endYear,
            'months' => $this->getMonth(),
            'month' => $currentMonth,
        ];
    }

    private function getMonth()
    {
        $months = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];

        $arrayMonth = []; 
        foreach($months as $key => $month)
        {
            $arrayMonth [] = [
                'text' => $month, 
                'value' => $key + 1
            ];
        }

        return $arrayMonth;
    }
}

