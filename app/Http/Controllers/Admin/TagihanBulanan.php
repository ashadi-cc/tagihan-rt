<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MasterTable\TableBulanan;


class TagihanBulanan extends Controller 
{
    use Util; 

    public function index(Request $request)
    {
        $table = TableBulanan::newTable(); 
        $data = $table->getData($request);
        $headerColumn = $table->getHeaderCaption(); 
        $headerData = $table->getHeaderData();

        return [
            'data' => $data,
            'headers' => $headerColumn, 
            'columns' => $headerData,
        ];
    }

}