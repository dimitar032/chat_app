<?php

namespace App\Http\Controllers;

use App\ChatRoom;
use App\Message;
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
                array_unique(
                    array_merge(
                        $request->input('selected_users_id'), //Note: Attach all selected users
                        [auth()->user()->id] //Note: attach auth user
                    )
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
     * Get chat room name with users from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
        if (Gate::denies('can-auth-user-see-chat-room', [$id])) {
            abort(403);
        }

        $chatRoom = ChatRoom::findOrFail($id);

        $data['chat_room_name'] = $chatRoom->name;
        $data['users'] = $chatRoom->users()->select('name')->get();

        return response()->json($data);
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

    /**
     * Store a newly created message to the chat room in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMessage(Request $request, $id)
    {
        if (Gate::denies('can-auth-user-see-chat-room', [$id])) {
            abort(403);
        }

        $this->validate($request, [
            'value' => 'required|min:1|max:65535',
        ]);

        DB::beginTransaction();
        try {
            $message = Message::create([
                'value' => $request->input('value'),
                'user_id' => auth()->user()->id,
            ]);

            $chatRoom = ChatRoom::findOrFail($id);

            $chatRoom->messages()->attach($message->id);
        } catch (\Throwable $e) {

            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return response()->json($message, 201);
    }

    /**
     * Get all messages in chat room from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMessages($id)
    {
        if (Gate::denies('can-auth-user-see-chat-room', [$id])) {
            abort(403);
        }

        $chatRoomMessages = DB::table('messages')
            ->select([
                'messages.id',
                'messages.value',
                'messages.created_at',
                'messages.user_id',
                'users.name as user_name',
            ])
            ->join('chat_room_message', 'messages.id', '=', 'chat_room_message.message_id')
            ->join('users', 'messages.user_id', '=', 'users.id')
            ->where('chat_room_message.chat_room_id', $id)
            ->orderBy('chat_room_message.created_at', 'ASC')
            ->limit(10000) //TODO: change with lazy loading
            ->get();

        return response()->json($chatRoomMessages);
    }
}
