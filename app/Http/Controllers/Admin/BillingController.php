<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\UploadBilling;

class BillingController extends Controller 
{
    public function index()
    {
        return view('admin.master.list_billing');
    }

    public function getUpload()
    {
        return view('admin.master.upload_billing');
    }

    public function postUpload(Request $request)
    {

        Util::validateExcelFile($request);

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