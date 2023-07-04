<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imap extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = [
        'queue'
    ];

    public function queue() {
        return $this->hasOne(Queue::class, 'id', 'queue_id');
    }
}
