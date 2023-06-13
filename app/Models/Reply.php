<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $with = [
        'user',
    ];


    public function ticket() {
        return $this->belongsTo(Ticket::class, 'id', 'ticket_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'author_id', 'user_id');
    }
}
