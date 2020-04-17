<?php 

namespace App\Utils; 

use App\User;
use App\Imports\BillingImport;
use Excel;
use Log; 


class UploadBilling  
{
    /**
     * use upload trait
     */
    use Upload; 

    /**
     * this should return true or false
     */
    protected function preProcessUpload($file)
    {
        try {
            $billingImport = new BillingImport; 
            Excel::import($billingImport, $file);

            //get result of import status
            $this->result = $billingImport->getResult();

            return true; 
        } catch(\Exception $e) {
            Log::error($e->getMessage()); 
            
            return false; 
        }
    }

    protected function getType()
    {
        return 'billing';
    }

}