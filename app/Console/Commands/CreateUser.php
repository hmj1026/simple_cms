<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user';

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
     * @return int
     */
    public function handle()
    {
        $email = $this->ask('Please enter email for creating your login account ?') ?: '';
        if ((string) Str::of($email)->match('/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/') === '') {
            $this->error('Email format error');
            return;
        }

        if (User::where('email', $email)->first()) {
            $this->error('Email account duplicated error');
            return;
        }

        $password = $this->secret('Please enter your password for login account ?') ?: '';
        if (Str::of($password)->length() < 7) {
            $this->error('Password length at least 8 digits');
            return;
        }

        $insertData = [
            'type'        => User::TYPE_ADMIN,
            'name'        => 'command',
            'email'       => $email,
            'password'    => Hash::make($password),
            'created_by'  => 'command',
            'updated_by' => 'command',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if ($user = User::insert($insertData)) {
            $this->info('Account : '.$email. ' created');
        } else {
            $this->error('Password length at least 8 digits');
        }
    }
}
