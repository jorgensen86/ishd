<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory()->create([
        //     'name' => "George Anastasiou",
        //     'username' => 'george',
        //     'administrator' => 1,
        //     'active' => 1,
        //     'email' => 'ganst@icop.gr',
        //     'password' => Hash::make("11111111"), // password
        // ]);

        // \App\Models\User::factory(10)->create();

        \App\Models\Ticket::factory(50)->hasReplies(5, function (array $attributes, \App\Models\Ticket $ticket) {
            return ['ticket_id' => $ticket->id];
        })->create();
        
    }
}
