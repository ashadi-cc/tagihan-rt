<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Upload\UploadUser;
use App\MasterTable\TableUser;


class WargaController extends Controller 
{
    use Util;

    public function index(Request $request)
    {
        $table = TableUser::NewTable(); 

        $data = [
            'headerTable' => $table->getHeaderCaption(),
            'headerData' => $table->getHeaderData(),
            'baseUrl' => url('/admin/master/warga/'),
        ];

        return view('admin.master.list_warga', $data);
    }

    public function getData(Request $request)
    {
        $table = TableUser::NewTable(); 

        return $table->getData($request);
    }

    public function delete($userId)
    {
        $table = TableUser::NewTable(); 
        $success = $table->delete($userId); 

        return ['success' => $success]; 
    }

    public function getUpload()
    {
        return view('admin.master.upload_warga');
    }

    public function postUpload(Request $request)
    {
        $this->validateExcelFile($request);

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