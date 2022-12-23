<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\EndUser;
use App\Models\ProfileAccount;

class UserConversationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    

    public function startConversation(Request $request)
    {
        $userOne = $request->user_one;
        $userTwo = $request->user_two;

        $conversation = Conversation::where('user_one', $userOne)->where('user_two', $userTwo)->first();

        if ($conversation) {
            return response()->json([
                'status' => 200,
                'message' => 'Conversation already exists',
                'data' => $conversation,
            ], 200);
        }

        $conversation = Conversation::where('user_one', $userTwo)->where('user_two', $userOne)->first();

        if ($conversation) {
            return response()->json([
                'status' => 200,
                'message' => 'Conversation already exists',
                'data' => $conversation,
            ], 200);
        }

        if ($userOne == $userTwo) {
            return response()->json([
                'status' => 400,
                'message' => 'You cannot start a conversation with yourself',
            ], 400);
        }

        $conversation = Conversation::create([
            'user_one' => $userOne,
            'user_two' => $userTwo,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Conversation started',
            'data' => $conversation,
        ], 200);
    }

    public function getAllUserConversations($user_id)
    {
        $conversations = Conversation::where('user_one', $user_id)->orWhere('user_two', $user_id)->get();

        if ($conversations->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No conversations found',
            ], 404);
        }

        foreach ($conversations as $conversation) {
            if ($conversation->user_one == $user_id) {
                $conversation->other_user = EndUser::select('id', 'avatar', 'name')->where('id', $conversation->user_two)->first();
            } else {
                $conversation->other_user = EndUser::select('id', 'avatar', 'name')->where('id', $conversation->user_one)->first();
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Conversations found',
            'data' => $conversations,
        ], 200);
    }

    public function getConversation($id)
    {
        $conversation = Conversation::where('id', $id)->first();

        if (!$conversation) {
            return response()->json([
                'status' => 404,
                'message' => 'Conversation not found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Conversation found',
            'data' => $conversation,
        ], 200);
    }

    public function deleteConversation($id)
    {
        $conversation = Conversation::where('id', $id)->first();

        if (!$conversation) {
            return response()->json([
                'status' => 404,
                'message' => 'Conversation not found',
            ], 404);
        }

        $conversation->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Conversation deleted',
        ], 200);
    }
}
