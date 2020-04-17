<?php 

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class Util 
{
    public static function validateExcelFile(Request $request)
    {
        $request->validate([
            'xls_file' => 'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}

