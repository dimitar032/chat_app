<?php

namespace App\Http\Controllers;

use App\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ChatRoomController extends Controller
{
    /**
     * Store a newly created chat room with attached users in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:55',
            'selected_users_id' => 'array|min:1',
            'selected_users_id.*' => 'required|exists:users,id',
        ]);


        DB::beginTransaction();
        try {
            $chatRoom = ChatRoom::create(['name' => $request->input('name')]);

            $chatRoom->users()->attach(
                array_merge(
                    $request->input('selected_users_id'), //Note: Attach all selected users
                    [auth()->user()->id] //Note: attach auth user
                )
            );

        } catch (\Throwable $e) {

            DB::rollBack();
            throw $e;
        }
        DB::commit();

        $chatRoom['_redirect_url'] = route('chat-room.show', ['id' => $chatRoom->id]);

        return response()->json($chatRoom, 201);
    }

    /**
     * Display the specified chat room.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('can-auth-user-see-chat-room', [$id])) {
            abort(403);
        }

        $chatRoom = ChatRoom::findOrFail($id);

        return view('chat-room', [
            'id' => $chatRoom->id,
        ]);
    }

}
