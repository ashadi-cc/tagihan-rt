<?php 

namespace App\Utils; 

use App\User;
use App\Imports\UserImport;
use Excel;
use Log; 


class UploadUser extends Upload 
{
    protected $uploadType = 'user'; 

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

    //must create this
    public static function NewUpload(User $user)
    {
        $upload = New self();
        $upload->setUser($user);

        return $upload;
    }
}