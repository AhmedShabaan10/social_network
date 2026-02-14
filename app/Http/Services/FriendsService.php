<?php

namespace App\Http\Services;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FriendsService
{
    public function getFriends()
    {
        $user = Auth::user();
        $friends = $user->friends()->wherePivot('status', Friend::STATUS_ACCEPTED)->get();
        return $friends;
    }

    public function viewOthers($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }
        return $user;
    }


    public function sendRequest($id)
    {
        $from = Auth::id();
        $to = $id;

        if ($from == $to) {
            return 3;
        }

        $existingRequest = Friend::checkFriendshipStatus($from, $to);

        $user = User::find($to);
        if (!$user) {
            return 4;
        }

        if ($existingRequest !== Friend::CAN_SEND) {
            return $existingRequest;
        }

        $friendship = Friend::create([
            'user_id' => $from,
            'friend_id' => $to,
            'status' => Friend::STATUS_PENDING,
        ]);

        return $friendship;
    }


    public function acceptRequest($id)
    {
        $from = Auth::id();
        $to = $id;

        $user = User::find($to);
        if (!$user) {
            return false;
        }

        $friendship = Friend::betweenUsers($from, $to)
            ->where('status', Friend::STATUS_PENDING)
            ->first();

        if (!$friendship) {
            return false;
        }

        $friendship->status = Friend::STATUS_ACCEPTED;
        $friendship->save();

        return $friendship;
    }


    public function rejectRequest($id)
    {
        $from = Auth::id();
        $to = $id;

        $user = User::find($to);
        if (!$user) {
            return false;
        }

        $friendship = Friend::betweenUsers($from, $to)
            ->where('status', Friend::STATUS_PENDING)
            ->first();

        if (!$friendship) {
            return false;
        }

        $friendship->delete();

        return $friendship;
    }

}
