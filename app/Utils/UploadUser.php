<?php 

namespace App\Utils; 

use App\User;
use App\Imports\UserImport;
use Excel;
use Log; 

class UploadUser 
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
            $userImport = new UserImport; 
            Excel::import($userImport, $file);

            //get result of import status
            $this->result = $userImport->getResult();

            return true; 
        } catch(\Exception $e) {
            Log::error($e->getMessage()); 
            
            return false; 
        }
    }

    protected function getType()
    {
        return 'user';
    }

}