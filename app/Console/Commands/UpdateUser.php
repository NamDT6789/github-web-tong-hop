<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User as User;
use Illuminate\Support\Facades\Hash;

class UpdateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'submission:updateUser {email_update} {username} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $email_update = $this->argument('email_update');
        $username = $this->argument('username');
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email',$email_update)->first();
        if ($user) {
             $user->name = $username;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();
            echo 'success';
        } else {
            echo 'update user failed';
        }


    }
}
