<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $with = [
        'user',
        'notifications'
    ];

    protected $guarded = [
        'reply_id'
    ];

    protected $appends = [
        'date_added'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:m',
    ];

    public function ticket() {
        return $this->belongsTo(Ticket::class, 'id', 'ticket_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'author_id', 'user_id');
    }

    public function notifications() {
        return $this->morphMany(Notification::class, 'model');
    }

    protected function dateAdded(): Attribute
    {
        return new Attribute(
            get: fn () => $this->created_at->diffForHumans()
        );
    }
}
