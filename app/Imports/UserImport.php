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

    private $Users;
    
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
        $this->users = User::warga()->get();

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
        $usernameInput = str_replace('-', '', $usernameInput);
        if (trim($usernameInput) == "")
        {
            return false;
        }

        $blokInput = strtoupper($row[0]); 
        $namaInput = $row[1]; 
        $emailInput = $row[2]; 
        $isAdmin = strtolower($row[3]) == 'y' ? true : false; 
        $emailInput = filter_var($emailInput, FILTER_VALIDATE_EMAIL) ? $emailInput : ($usernameInput . config('default.hostmail')); 

        $user = $this->users->first(function($value, $key) use ($usernameInput) {
            return $value->username == $usernameInput;
        });

        if (!$user) {
            $user = new User();
            $user->username = $usernameInput; 
            $user->default_password = $this->generateRandomString();
            $user->password = Hash::make($user->default_password);
        }
        
        $user->blok = $blokInput; 
        $user->name = $namaInput;
        $user->email = $emailInput; 

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