<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a users of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $this->validate($request, ['query' => 'required|min:2|max:55']);

        $queryParam = $request->input('query');

        return User::select('id', 'name', 'email')
            ->where('name', $queryParam)
            ->orWhere('email', $queryParam)
            ->get();
    }

    /**
     * Display all chat rooms where auth user is present
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllChatRooms($id)
    {
        if (Gate::denies('is-this-user-the-auth-user', [$id])) {
            abort(403);
        }

        $user = User::findOrFail($id);

        $userChatRooms = $user->chat_rooms()
            ->select(
                'chat_rooms.id',
                'chat_rooms.name',
            )
            ->get();

        return response()->json($userChatRooms);
    }
}
