<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'submission:addUser {username} {email} {password}';

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
        $username = $this->argument('username');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $user = User::query()
            ->where('email', $email)
            ->first();
        if ($user) {
            echo "Add user fail ";
        } else {
            $items = new User();
            $items->name = $username;
            $items->email = $email;
            $items->password = Hash::make($password);
            $items->created_at = now();
            if ($items->save()) {
                echo "Add user success";
            }
        }
    }
}
