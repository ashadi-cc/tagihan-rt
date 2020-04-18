<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Upload\UploadBilling;
use App\MasterTable\TableBilling;

class BillingController extends Controller 
{
    use Util; 

    public function index()
    {
        $table = TableBilling::NewTable(); 

        $data = [
            'headerTable' => $table->getHeaderCaption(),
            'headerData' => $table->getHeaderData(),
            'baseUrl' => url('/admin/master/tagihan/'),
        ];

        return view('admin.master.list_billing', $data);
    }

    public function getData(Request $request)
    {
        $table = TableBilling::NewTable(); 

        return $table->getData($request);
    }

    public function delete($billingId)
    {
        $table = TableBilling::NewTable(); 
        $success = $table->delete($billingId); 

        return ['success' => $success]; 
    }

    public function getUpload()
    {
        return view('admin.master.upload_billing');
    }

    public function postUpload(Request $request)
    {

        $this->validateExcelFile($request);

        $file = $request->file('xls_file'); 

        $upload = UploadBilling::NewUpload($request->user());
        $success = $upload->process($file); 
        
        if (!$success) {
            return redirect()->back()->withErrors(['file' =>  'format file tidak sesuai dengan template']);
        }

        $result = $upload->getResult(); 
        $message = [
            'success' => 'data master tagihan berhasil di import', 
            'imported' => count($result['success']), 
            'fail' => count($result['fail']),
        ];
        return redirect()->back()->with($message);
    }

}