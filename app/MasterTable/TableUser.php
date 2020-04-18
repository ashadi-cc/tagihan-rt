<?php 

namespace App\MasterTable; 

use App\User; 
use Illuminate\Http\Request;
use Log;


class TableUser implements TableInterface
{
    use Table;

    public function setHeaderCaption() :array 
    {
        return [
            'Blok',
            'Nama',
            'Email',
            'Admin?',
        ];
    }

    public function setHeaderData() : array 
    {
        return [
            'id',
            'blok',
            'name',
            'email', 
            'is_admin',
        ];
    }

    public function delete($userId)
    {
        $currentUser = auth()->user(); 
        if ($currentUser->id == $userId) {
            return false;
        }

        try {
            $user = User::findOrFail($userId); 
            $user->blok = 'delete-' . $user->id . $user->blok; 
            $user->username = 'delete-' .  $user->id . $user->username; 
            $user->email = 'delete-' .  $user->id . $user->email; 
            $user->save();
            
            //finally delete it
            $user->delete();

            return true; 
        } catch(\Exception $e) {
            Log::error($e->getMessage()); 
            return false;
        }
    }

    public function getData(Request $request)
    {
        $query = User::with('roles')
            ->orderBy('blok', 'asc');
        
        if (trim($request->get('q')) != "") {
            $search = '%'. trim($request->get('q')) . '%'; 
            $query->where('blok', 'like', $search)
                ->orWhere('name', 'like', $search)
            ;
        }

        $data = $query->get()->toArray();

        return array_map(function($value)
        {
            return [
                'id' => $value['id'],
                'blok' => $value['blok'], 
                'name' => $value['name'],
                'email' => $value['email'],
                'is_admin' => $this->isAdmin($value['roles']),
            ];

        }, $data);
    }

    private function isAdmin($roles)
    {
        foreach($roles as $role)
        {
            if ($role['name'] == 'admin')
            {
                return 'Yes';
            }
        }

        return 'No';
    }
}