<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Billing;
use App\Exports\BillingTemplateExport;
use Excel;
use App\Utils\Upload\UploadBillingUser;

class TagihanController extends Controller 
{
    use Util; 

    public function index()
    {
        $filterOptions = $this->getFilterYearandMonth();
        $billings = Billing::orderBy('name', 'asc')->get()->toArray();

        return view('admin.master.list_tagihan', [
            'options' => $filterOptions, 
            'billings' => $billings,
        ]);
    }

    public function getData(Request $request)
    {
        return [];
    }


    public function getTemplate($idTemplate)
    {
        $billing = Billing::findOrFail($idTemplate); 
        $billingExport = new BillingTemplateExport;
        $billingExport->setBilling($billing);

        return Excel::download($billingExport, $billingExport->getTemplateFileName());
    }

    public function uploadTagihan(Request $request)
    {
        $this->validateExcelFile($request);

        $file = $request->file('xls_file'); 
        $upload = UploadBillingUser::NewUpload($request->user());
        $success = $upload->process($file); 
        
        if (!$success) {
            return [
                'success' => false,
                'message' => 'File format tidak sesuai'
            ];
        }

        $result = $upload->getResult(); 
        $message = [
            'success' => true, 
            'imported' => count($result['success']), 
            'fail' => count($result['fail']),
        ];

        return $message;

    }
}