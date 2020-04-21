<?php 

namespace App\MasterTable; 

use App\Models\Payment; 
use Illuminate\Http\Request;
use Log;


class TablePayment implements TableInterface
{
    use Table;

    public function setHeaderCaption() :array 
    {
        return [
            'Nama',
        ];
    }

    public function setHeaderData() : array 
    {
        return [
            'id',
            'name',
        ];
    }

    public function getData(Request $request)
    {
        $query = Payment::orderBy('name', 'asc');
        
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
            ];

        }, $data);
    }

    public function delete($paymentId)
    {
        try {
            $payment = Payment::findOrFail($paymentId); 
            $payment->delete(); 

            return true;
        } catch(\Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }

    public function edit(Request $request, $idRecord)
    {
        $request->validate([
            'nama' => 'required', 
        ]); 

        $payment = Payment::findOrFail($idRecord); 

        $payment->name = $request->nama; 

        $payment->save(); 
    }

    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required', 
        ]); 

        $payment = new Payment(); 

        $payment->name = $request->nama; 

        $payment->save(); 
    }

}