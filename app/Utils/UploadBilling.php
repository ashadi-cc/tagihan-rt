<?php 

namespace App\Utils; 

use App\User;
use App\Imports\BillingImport;
use Excel;
use Log; 


class UploadBilling extends Upload 
{
    protected $uploadType = 'billing'; 

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

    //must create this
    public static function NewUpload(User $user)
    {
        $upload = New self();
        $upload->setUser($user);

        return $upload;
    }
}