<?php 

namespace App\Imports; 

use App\Models\Billing;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Log;

class BillingImport implements ToCollection
{
    private $successImport = array(); 

    private $failImport = array(); 

    public function getResult()
    {
        return [
            'success' => $this->successImport,
            'fail' => $this->failImport,
        ];
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) 
        {
            if (count($row) != 2) {
                throw new \Exception("file format is not valid");
            }

            try {
                $saved = $this->saveBilling($key, $row);
                if ($saved) {
                    $this->successImport[] = [
                        'index' => ($key + 1), 
                        'data' => $row
                    ]; 
                }
                
            } catch(\Exception $e) {
                Log::error($e->getMessage()); 
                
                $this->failImport[] = [
                    'index' => ($key + 1), 
                    'data' => $row
                ]; 
            }
        }
    }

    protected function saveBilling($key, $row)
    {
        if ($key == 0) {
            return false;
        }

        $nameInput = $row[0]; 
        $amountInput = is_numeric($row[1]) ? $row[1]: '0'; 

        $billing = Billing::where('name', 'like', $nameInput)->first(); 
        if (!$billing) {
            $billing = Billing::create(['name' => $nameInput, 'auto_per_month' => false]); 
        }

        $billing->amount = $amountInput; 
        $billing->save();

        return true;
    }
}