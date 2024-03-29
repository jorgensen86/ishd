<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketNumber extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function ticketable() {
        return $this->morphTo();
    }
}
