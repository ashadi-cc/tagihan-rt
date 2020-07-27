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
            'QR Code',
        ];
    }

    public function setHeaderData() : array 
    {
        return [
            'id',
            'name',
            'qr_code',
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
                'qr_code' => $value['qr_code'] ? 'Yes': 'No',
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
        $validate = [
            'nama' => 'required', 
        ];
        
        if ($request->has('qr_code')) {
            $validate['qr_code'] =  'required|file|image|mimes:jpeg,png,gif,webp|max:2048'; 
        }

        $request->validate($validate);

        $payment = Payment::findOrFail($idRecord); 

        $payment->name = $request->nama; 

        $payment->save(); 

        $image = $request->file('qr_code'); 
        if ($image) {
            $imageName = 'qrcode-'. $payment->id . '.'. $image->getClientOriginalExtension();
            $payment->qr_code = $imageName; 
            $image->move(public_path('qr-payment'), $imageName);
            $payment->save();
        }
    }

    public function create(Request $request)
    {
        $validate = [
            'nama' => 'required', 
        ];
        
        if ($request->has('qr_code')) {
            $validate['qr_code'] =  'required|file|image|mimes:jpeg,png,gif,webp|max:2048'; 
        }

        $payment = new Payment(); 

        $payment->name = $request->nama; 

        $payment->save(); 

        $image = $request->file('qr_code'); 
        if ($image) {
            $imageName = 'qrcode-'. $payment->id . '.'. $image->getClientOriginalExtension();
            $payment->qr_code = $imageName; 
            $image->move(public_path('qr-payment'), $imageName);
            $payment->save();
        }
    }

}