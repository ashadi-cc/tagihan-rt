<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Billing;
use App\Exports\BillingTemplateExport;
use Excel;

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

        dd($file);
    }
}