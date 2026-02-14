<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\FriendsService;


class FriendsController extends Controller
{
    protected $friendsService;

    public function __construct(FriendsService $friendsService)
    {
        $this->friendsService = $friendsService;
    }

    public function friendsList()
    {
        $friends = $this->friendsService->getFriends();
        return response()->json([
            'status' => true,
            'friends' => $friends->map(function ($friend) {
                return [
                    'id' => $friend->id,
                    'name' => $friend->name,
                    'email' => $friend->email,
                    'bio' => $friend->bio,
                    'image' => $friend->image ? asset($friend->image) : null
                ];
            })
        ]);
    }

    public function viewOthers($userId)
    {
        $user = $this->friendsService->viewOthers($userId);
        if (is_string($user)) {
            return response()->json([
                'status' => false,
                'message' => $user
            ], 404);
        }
        return response()->json([
            'status' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'bio' => $user->bio,
                'image' => $user->image ? asset($user->image) : null
            ]
        ]);
    }

    public function sendRequest($id)
    {
        $result = $this->friendsService->sendRequest($id);
        if (is_int($result)) {
            return response()->json([
                'status' => false,
                'message' => match ($result) {
                    1 => 'Friend request already sent',
                    2 => 'You are already friends',
                    3 => 'You cannot send a friend request to yourself',
                    4 => 'User not found',
                    default => 'Unknown error'
                }
            ], 400);
        }
        return response()->json([
            'status' => true,
            'message' => 'Friend request sent'
        ]);
    }


    public function acceptRequest($to)
    {
        $result = $this->friendsService->acceptRequest($to);
        if (!$result) {
            return response()->json([
                'status' => false,
                'message' => 'Friend request not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Friend request accepted'
        ]);
    }

    public function rejectRequest($to)
    {
        $result = $this->friendsService->rejectRequest($to);
        if (!$result) {
            return response()->json([
                'status' => false,
                'message' => 'Friend request not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Friend request rejected'
        ]);
    }


}
