<?php 

namespace App\MasterTable; 

use App\User; 
use Illuminate\Http\Request;
use Log;
use Hash;


class TableUser implements TableInterface
{
    use Table;

    public function setHeaderCaption() :array 
    {
        return [
            'Username',
            'Blok',
            'Nama',
            'Email',
            'Default Password',
            'Admin?',
        ];
    }

    public function setHeaderData() : array 
    {
        return [
            'id',
            'username',
            'blok',
            'name',
            'email', 
            'default_password',
            'is_admin',
        ];
    }

    public function edit(Request $request, $idRecord)
    {
        $user = User::findOrFail($idRecord); 

        $validation = [
            'nama' => 'required',
        ]; 

        if ($request->email) {
            $validation['email'] = 'required|email|unique:users,email,'. $user->id;
            $user->email = $request->email; 
        }

        if ($request->password) {
            $validation['password'] = 'required|min:5';
            $user->password = Hash::make($request->password);
            $user->default_password = ''; 
        }

        $request->validate($validation); 
        $user->name = $request->nama; 

        $user->save();

        if (auth()->user()->id == $user->id) {
            return;
        }

        if ($request->is_admin) {
            $user->assignRole('admin');
        } else {
            $user->removeRole('admin');
        }
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
        $query = User::warga()->with('roles')
            ->orderBy('id', 'asc');
        
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
                'username' => $value['username'],
                'blok' => $value['blok'], 
                'name' => $value['name'],
                'email' => $value['email'],
                'default_password' => $value['default_password'] ? $value['default_password'] : 'sudah dirubah',
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