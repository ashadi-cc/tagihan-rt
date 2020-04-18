<?php 

namespace App\Imports; 

use App\User;
use Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Log;

class UserImport implements ToCollection, ImportDataInterface
{
    use ImportData;

    private $emailTemplate = '@gmr-04.xyz'; 
    
    public function validate($row)
    {
        return $this->checkHeader([
            'blok',
            'nama',
            'email',
            'is_admin',
        ], $row);
    }

    public function processData(Collection $rows)
    {
        foreach ($rows as $key => $row) 
        {
            try {
                $saved = $this->saveUser($key, $row);
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

    protected function saveUser($key, $row)
    {
        if ($key == 0) 
        {
            return false;
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
            $user->default_password = $this->generateRandomString();
            $user->password = Hash::make($user->default_password);
        }
        $user->save();
        
        if ($isAdmin) {
            $user->assignRole('admin'); 
        }

        return true;
    }

    public function generateRandomString($length = 6) 
    {
        return substr(str_shuffle(str_repeat($x='0123456789', ceil($length/strlen($x)) )), 1, $length);
    }
}