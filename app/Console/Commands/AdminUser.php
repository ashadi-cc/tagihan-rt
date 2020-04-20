<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Hash; 

class AdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create an admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = User::firstOrNew([
            'username' => 'admin',
        ]); 

        $user->username = 'admin';
        $user->blok = 'admin';
        $user->name = 'Ashadi Cahyadi';
        $user->email = 'admin.cc@gmail.com'; 
        $user->password = Hash::make('k0mp1l451'); 
        $user->default_password = ''; 
        $user->save(); 

        //assign admin role 
        $user->assignRole('admin'); 
    }
}
