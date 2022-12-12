<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use Illuminate\Http\Request;

class UserMessagesController extends Controller
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


    public function sendMessage(Request $request)
    {
        $conversation = $request->conversation_id;
        $sender = $request->sender_id;
        $message = $request->message;

        $message = Messages::create([
            'conversation_id' => $conversation,
            'sender_id' => $sender,
            'message' => $message,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Message sent',
            'data' => $message,
        ], 200);
    }

    public function getConversationMessages($conversation_id)
    {
        $messages = Messages::where('conversation_id', $conversation_id)->orderBy('created_at', 'desc')->with('sender')->get();

        return response()->json([
            'status' => 200,
            'message' => 'Messages found',
            'data' => $messages,
        ], 200);
    }


    public function getConversationMessagesWithPagination($conversation_id)
    {
        $messages = Messages::where('conversation_id', $conversation_id)->orderBy('created_at', 'desc')->with('sender')->paginate(10);

        return response()->json([
            'status' => 200,
            'message' => 'Messages found',
            'data' => $messages,
        ], 200);
    }

    public function deleteMessage($message_id)
    {
        $message = Messages::find($message_id);

        if (!$message) {
            return response()->json([
                'status' => 404,
                'message' => 'Message not found',
            ], 404);
        }

        $message->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Message deleted',
        ], 200);
    }
}
