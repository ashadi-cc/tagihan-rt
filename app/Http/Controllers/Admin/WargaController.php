<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Upload\UploadUser;


class WargaController extends Controller 
{
    public function index()
    {
        return view('admin.master.list_warga');
    }

    public function getUpload()
    {
        return view('admin.master.upload_warga');
    }

    public function postUpload(Request $request)
    {
        Util::validateExcelFile($request);

        $file = $request->file('xls_file'); 

        $upload = UploadUser::NewUpload($request->user());
        $success = $upload->process($file); 
        
        if (!$success) {
            return redirect()->back()->withErrors(['file' =>  'format file tidak sesuai dengan template']);
        }

        $result = $upload->getResult(); 
        $message = [
            'success' => 'data warga berhasil di import', 
            'imported' => count($result['success']), 
            'fail' => count($result['fail']),
        ];
        return redirect()->back()->with($message);
    }
}