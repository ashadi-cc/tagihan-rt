<?php 

namespace App\MasterTable; 

use App\Models\BillingUser; 
use Illuminate\Http\Request;
use Log;


class TableBulanan implements TableInterface
{
    use Table;

    private $masterBilling; 
    private $users; 
    private $headers; 

    private function generateHeader()
    {
        $headers = ['Blok'];
        $headerData = [[
            'header' => 'Blok',
            'value' => 'blok',
        ]];
        $users = []; 

        foreach($this->masterBilling as $item) {
            $billName = $item->billing_name; 
            $billId = 'b_' . $item->billing_id; 

            if (!in_array($billName, $headers)) {
                $headers[] = $billName; 
                $headerData[] = [
                    'header' => $billName,
                    'value' => $billId,
                ];
            }

            if (!in_array($item->user_blok, $users)) {
                $users[] = $item->user_blok;
            }
        } 

        $this->users = $users; 
        $this->headers = $headerData;
    }

    private function generatePivot()
    {
        $columns = $this->setHeaderData();

        $records = [];
        foreach($this->users as $user)
        {
            $row = [
                'blok' => $user
            ]; 

            foreach($columns as $column)
            {
                if ($column != 'blok') {
                    $billingId = str_replace('b_', '', $column); 
                    $found = $this->masterBilling->first(function($value, $key) use($user, $billingId) {
                        if ($value->user_blok == $user && $value->billing_id == $billingId) {
                            return true;
                        }

                        return false;
                    });

                    if ($found) {
                        $row[$column] = [
                            'id' => $found->id, 
                            'amount' => $found->amount,
                            'status' => $found->status,
                        ];
                    } else {
                        $row[$column] = false;
                    }
                }
            }

            $records[] = $row;
        }

        return $records; 
    }

    public function setHeaderCaption() :array 
    {
        return array_map(function($value) {
            return $value['header'];
        }, $this->headers);
    }

    public function setHeaderData() : array 
    {
        return array_map(function($value) {
            return $value['value'];
        }, $this->headers);
    }

    public function getData(Request $request)
    {
        $year = $request->year ?:'0';
        $month = $request->month ?:'0';
        $this->masterBilling = BillingUser::where([
            'year' => $year,
            'month' => $month,
        ])->orderBy('user_id')->get();

        $this->generateHeader();

        return $this->generatePivot();
    }

    public function delete($billingId)
    {

    }

    public function edit(Request $request, $idRecord)
    {
        try {
            $billing = BillingUser::findOrFail($idRecord); 

            if ($request->amount) {
                $billing->amount = $request->amount;
            }

            if ($request->status) {
                $billing->status = $request->status; 
            }

            $billing->save(); 

            return true; 
        } catch(\Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }

}