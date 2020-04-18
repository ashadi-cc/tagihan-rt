<?php 

namespace App\MasterTable; 

use App\Models\Billing; 
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
            $billing->delete(); 

            return true;
        } catch(\Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }

}