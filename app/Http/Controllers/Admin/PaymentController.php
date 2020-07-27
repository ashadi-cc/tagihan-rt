<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MasterTable\TablePayment;
use App\Models\Payment;


class PaymentController extends Controller 
{
    use Util; 

    public function index()
    {
        $table = TablePayment::NewTable(); 

        $data = [
            'headerTable' => $table->getHeaderCaption(),
            'headerData' => $table->getHeaderData(),
            'baseUrl' => url('/admin/master/payment'),
        ];

        return view('admin.master.list_payment', $data);
    }

    public function getData(Request $request)
    {
        $table = TablePayment::NewTable(); 

        return $table->getData($request);
    }

    public function delete($paymentId)
    {
        $table = TablePayment::NewTable(); 
        $success = $table->delete($paymentId); 

        return ['success' => $success]; 
    }

    public function edit($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        
        return view('admin.master.edit_payment', ['payment' => $payment]);
    }

    public function postEdit(Request $request, $paymentId)
    {
        $table = TablePayment::NewTable(); 
        $table->edit($request, $paymentId);

        return redirect('/admin/master/payment')->with('success', 'Data berhasil dirubah');
    }

    public function store(Request $request)
    {
        $table = TablePayment::NewTable(); 
        $table->create($request); 

        return redirect('/admin/master/payment')->with('success', 'Data baru berhasil disimpan');
    }

}