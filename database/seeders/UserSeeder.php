<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $user = User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
         ]);
         $token = $user->createToken('test');
        if (isset($this->command)) {
            $this->command->getOutput()->writeln("<info>Token: </info>".$token->plainTextToken);
        }
    }
}
