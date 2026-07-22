<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'atebapatrice22@gmail.com';

        $user = User::firstOrNew(['email' => $email]);
        $user->name = $user->name ?: 'Patrice A.';
        $user->password = Hash::make('12345678');
        $user->is_admin = true;
        $user->email_verified_at = $user->email_verified_at ?: now();
        $user->save();

        $this->command->info("Admin user created/updated: {$email} (id={$user->id})");
    }
}
