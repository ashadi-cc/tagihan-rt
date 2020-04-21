<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MasterTable\TableBulanan;


class TagihanBulanan extends Controller 
{
    use Util; 

    public function index()
    {
        $options = $this->getFilterYearandMonth(); 
        
        return view('admin.master.list_bulanan', ['options' => $options]);
    }

    public function getData(Request $request)
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

    public function edit(Request $request, $idRecord)
    {
        $table = TableBulanan::newTable(); 
        $success = $table->edit($request, $idRecord); 

        return ['success' => true];
    }

}