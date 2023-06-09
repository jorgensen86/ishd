<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() 
    {
        $invoice  = Invoice::with('user')->whereNotNull('user_id')->get()->random(1);

        return [
            'author_id' => $this->faker->randomElement($invoice)['user_id'],
            'invoice_id' => $this->faker->randomElement($invoice)['invoice_id'],
            'invoice_number' => $this->faker->randomElement($invoice)['invoice_number'],
            'subject' => fake()->sentence(),
            'body' => fake()->paragraphs(5, true),
        ];
    }
}
