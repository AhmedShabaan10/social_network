<?php

namespace App\Http\Controllers;

use App\Events\FriendRequestSent;
use App\Http\Services\FriendsService;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    protected $friendsService;

    public function __construct(FriendsService $friendsService)
    {
        $this->friendsService = $friendsService;
    }

    public function index()
    {
        $user = auth()->user();

        $friends = ($user->friendsSent ?? collect())
            ->merge($user->friendsReceived ?? collect())
            ->unique('id');

        $requests = Friend::where('friend_id', $user->id)
            ->where('status', Friend::STATUS_PENDING)
            ->with('user')
            ->get();

        return view('friends', compact('friends', 'requests'));
    }


    public function viewUser($id)
    {
        $user = $this->friendsService->viewOthers($id);
        return view('friends.user', compact('user'));
    }


    public function sendRequest($id)
    {
        $result = $this->friendsService->sendRequest($id);

        if ($result instanceof Friend) {
            return response()->json(['status' => 'ok']);
        }
        event(new FriendRequestSent(Auth::user()->id, $id));
        return response()->json(['message' => 'Request failed'], 400);
    }

    public function acceptRequest($id)
    {
        $result = $this->friendsService->acceptRequest($id);

        if ($result instanceof Friend) {
            return response()->json(['status' => 'ok']);
        }

        return response()->json(['message' => 'Accept failed'], 400);
    }


    public function reject($id)
    {
        $result = $this->friendsService->rejectRequest($id);
        return redirect()->back()->with('status', 'Friend request rejected.');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $users = User::where('name', 'LIKE', "%{$query}%")
            ->where('id', '!=', auth()->id())
            ->get();

        return view('dashboard', compact('users'));
    }


}
