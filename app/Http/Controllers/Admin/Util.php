<?php 

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

trait Util 
{
    public function validateExcelFile(Request $request)
    {
        $request->validate([
            'xls_file' => 'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}

