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
        $request->validate([
            'xls_file' => 'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]); 

        $file = $request->file('xls_file'); 

        $upload = UploadBilling::NewUpload($request->user());
        $success = $upload->process($file); 
        
        if (!$success) {
            return redirect()->back()->withErrors(['file' =>  'isi file tidak sesuai dengan template']);
        }

        $result = $upload->getResult(); 
        $message = [
            'success' => 'data master berhasil di import', 
            'imported' => count($result['success']), 
            'fail' => count($result['fail']),
        ];
        return redirect()->back()->with($message);
    }

}