<?php 

namespace App\MasterTable; 

use App\Models\Billing; 
use App\Models\BillingUser;
use Illuminate\Http\Request;
use Log;


class TableBilling implements TableInterface
{
    use Table;

    public function setHeaderCaption() :array 
    {
        return [
            'Nama',
            'Nominal',
        ];
    }

    public function setHeaderData() : array 
    {
        return [
            'id',
            'name',
            'amount',
        ];
    }

    public function getData(Request $request)
    {
        $query = Billing::orderBy('name', 'asc');
        
        if (trim($request->get('q')) != "") {
            $search = '%'. trim($request->get('q')) . '%'; 
            $query->where('name', 'like', $search);
        }

        $data = $query->get()->toArray();

        return array_map(function($value)
        {
            return [
                'id' => $value['id'],
                'name' => $value['name'], 
                'amount' => number_format($value['amount'], 2),
            ];

        }, $data);
    }

    public function delete($billingId)
    {
        
        try {
            $billing = Billing::findOrFail($billingId); 
            $billingUser = BillingUser::where('billing_id', $billing->id)->first();
            if ($billingUser) {
                return false;
            }

            $billing->delete(); 
            return true;
        } catch(\Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }

    public function edit(Request $request, $idRecord)
    {
        $request->validate([
            'nama' => 'required|max:100', 
            'nominal' => 'required',
        ]); 

        $billing = Billing::findOrFail($idRecord); 

        $billing->name = $request->nama; 
        $billing->amount = $request->nominal; 

        $billing->save(); 

        BillingUser::where('billing_id', $billing->id)->update([
            'billing_name' => $billing->name
        ]); 

    }

}