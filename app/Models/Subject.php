<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'queue_id',
        'active'
    ];

    protected $with = [
        'queue'
    ];

    public function queue() {
        return $this->belongsTo(Queue::class);
    }
}
