<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';


    const CAN_SEND = 0;
    const IS_PENDING = 1;
    const IS_FRIENDS = 2;

    

    protected $table = 'friends';
    protected $fillable = [
        'user_id',
        'friend_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    public function scopeBetweenUsers($query, $user1, $user2)
    {
        return $query->where(function ($q) use ($user1, $user2) {
            $q->where('user_id', $user1)->where('friend_id', $user2);
        })->orWhere(function ($q) use ($user1, $user2) {
            $q->where('user_id', $user2)->where('friend_id', $user1);
        });
    }


    public function scopeCheckFriendshipStatus($query, $from, $to)
    {
        $friendship = $query->betweenUsers($from, $to)->first();

        if (!$friendship) {
            return 0;
        }

        return match ($friendship->status) {
            self::STATUS_PENDING => 1,
            self::STATUS_ACCEPTED => 2,
            default => 0,
        };
    }


}
