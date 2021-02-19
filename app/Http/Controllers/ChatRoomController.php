<?php

namespace App\Http\Controllers;

use App\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

            $chatRoom->users()->attach($request->input('selected_users_id'));

        } catch (\Throwable $e) {

            DB::rollBack();
            throw $e;
        }
        DB::commit();
        
        return response()->json($chatRoom, 201);
    }

}
