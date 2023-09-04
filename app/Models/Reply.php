<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Reply extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    
    public $timestamps = false;

    protected $with = [
        'user',
        'notifications'
    ];

    protected $guarded = [
        'reply_id'
    ];

    // protected $appends = [
    //     'date_added'
    // ];

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

    protected function humanDate(): Attribute
    {
        return new Attribute(
            get: fn () => $this->created_at->diffForHumans()
        );
    }
}
