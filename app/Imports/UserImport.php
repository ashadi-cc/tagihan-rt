<?php 

namespace App\Imports; 

use App\User;
use Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Log;

class UserImport implements ToCollection
{
    private $emailTemplate = '@gmr-04.xyz'; 
    
    private $prefixPassword = 'rt4'; 

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
            if (count($row) != 4) {
                throw new \Exception("file format is not valid");
            }

            try {
                $this->saveUser($key, $row);
                
                if ($key > 0 ) {
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

    protected function saveUser($key, $row)
    {
        if ($key == 0) {
            return; 
        }

        $usernameInput = strtolower($row[0]); 
        $blokInput = strtoupper($row[0]); 
        $namaInput = $row[1]; 
        $emailInput = $row[2]; 
        $isAdmin = strtolower($row[3]) == 'y' ? true : false; 
        $emailInput = filter_var($emailInput, FILTER_VALIDATE_EMAIL) ? $emailInput : ($usernameInput . $this->emailTemplate); 


        $user = User::firstOrNew(['username' => $usernameInput]);  
        $user->name = $namaInput;

        //user is new record
        if (!$user->id) {
            $user->username = $usernameInput; 
            $user->blok = $blokInput; 
            $user->email = $emailInput; 
            $user->name = $namaInput; 
            $user->password = Hash::make($this->prefixPassword . $usernameInput);
        }
        $user->save();
        
        if ($isAdmin) {
            $user->assignRole('admin'); 
        }
    }
}