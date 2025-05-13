<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AssignAdminRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-admin-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $email = $this->ask('0990510232gury@gmail.com');
    $user = User::where('email', $email)->first();

    if (!$user) {
        $this->error("Пользователь не найден!");
        return;
    }

    // Создаем роль, если её нет
    Role::firstOrCreate(['name' => 'admin']);

    // Назначаем роль
    $user->assignRole('admin');
    $this->info("Роль 'admin' назначена для $email!");
}
}
