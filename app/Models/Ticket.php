<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $appends = [
        'date_added'
    ];

    protected $fillable = [
        'is_opened',
    ];

    protected $with = [
        'user',
        'invoice',
        'replies',
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:m',
        'updated_at' => 'datetime:d-m-Y H:m',
    ];

    protected $guarded = [];

    public function ticket_number() {
        return $this->morphOne(TicketNumber::class, 'ticketable');
    }

    public function invoice() {
        return $this->hasOne(Invoice::class, 'invoice_id', 'invoice_id');
    }

    public function user() {
        return $this->hasOne(User::class, 'user_id', 'author_id');
    }

    public function queue() {
        return $this->hasOne(Queue::class, 'id', 'queue_id');
    }

    public function replies() {
        return $this->hasMany(Reply::class, 'ticket_id', 'id');
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
