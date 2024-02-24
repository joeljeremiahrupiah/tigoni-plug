<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getChatData($product_id, $user_id)
    {
        $product = Product::find($product_id);

        $chats = Chat::where(function ($query) use ($user_id) {
            $query->where('user_id', $user_id)
                ->orWhere('vendor_id', $user_id);
        })
            ->with(['user', 'vendor', 'product', 'messages.user'])
            ->get();

        $currentChat = $chats->where('product_id', $product_id)->first();

        if (!$currentChat) {
            $latestchat = Chat::create([
                'chat_code' => \Str::uuid(),
                'user_id' => $user_id,
                'vendor_id' => $product->user_id,
                'product_id' => $product_id
            ]);

            $chats->prepend($latestchat);

            $product = $latestchat->product;
            $user = $product->user;

            $messages = $latestchat->messages;


            return response([
                "latestchat" => $latestchat,
                'product' => $product,
                'user' => $user,
                'chats' => $chats,
                'messages' => $messages,
                'status' => 200
            ], 200);
        } else {
            $latestchat = $chats->first();

            $product = $currentChat->product;
            $user = $product->user;

            $messages = $currentChat->messages;

            return response([
                "currentChat" => $currentChat,
                "latestchat" => $latestchat,
                'product' => $product,
                'user' => $user,
                'chats' => $chats,
                'messages' => $messages,
                'status' => 200
            ], 200);
        }
    }

    public function getAllChatData($user_id)
    {
        // $product = Product::where('user_id', $user_id)->first();

        $chats = Chat::where(function ($query) use ($user_id) {
            $query->where('user_id', $user_id)
                ->orWhere('vendor_id', $user_id);
        })
            ->with(['user', 'vendor', 'product', 'messages.user'])
            ->get();

        // $currentChat = $chats->where('product_id', $product->id)->first();

        // if (!$currentChat) {
        //     $latestchat = Chat::create([
        //         'chat_code' => \Str::uuid(),
        //         'user_id' => $user_id,
        //         'vendor_id' => $product->user_id,
        //         'product_id' => $product->id
        //     ]);

        //     $chats->prepend($latestchat);

        //     $product = $latestchat->product;
        //     $user = $product->user;

        //     $messages = $latestchat->messages;


        //     return response([
        //         "latestchat" => $latestchat,
        //         'product' => $product,
        //         'user' => $user,
        //         'chats' => $chats,
        //         'messages' => $messages,
        //         'status' => 200
        //     ], 200);
        // } else {
        //     $latestchat = $chats->first();

        //     $product = $currentChat->product;
        //     $user = $product->user;

        //     $messages = $currentChat->messages;

        //     return response([
        //         "currentChat" => $currentChat,
        //         "latestchat" => $latestchat,
        //         'product' => $product,
        //         'user' => $user,
        //         'chats' => $chats,
        //         'messages' => $messages,
        //         'status' => 200
        //     ], 200);
        // }

        return response(['chats' => $chats, 'status' => 200], 200);
    }

    public function getAdminChatData($id)
    {
        $adminUser = User::find($id);

        $adminProducts = Product::where('user_id', $id)->get();

        $chats = Chat::whereIn('product_id', $adminProducts->pluck('id'))
            ->with(['user', 'vendor', 'product', 'messages.user'])
            ->get();

        $latestChat = $chats->first();

        return response([
            'adminUser' => $adminUser,
            'adminProducts' => $adminProducts,
            'chats' => $chats,
            'latestChat' => $latestChat,
            'status' => 200,
        ], 200);
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'chatId' => 'required|exists:chats,id',
            'content' => 'required|string',
        ]);

        $message = Message::create([
            'chat_id' => $request->chatId,
            'user_id' => $id,
            'content' => $request->content,
        ]);

        $messageWithRelationships = Message::with(['chat', 'user', 'chat.user', 'chat.product', 'chat.product.user'])
            ->find($message->id);

        $chat = Chat::where('id', $message->chat_id)->with(['user', 'vendor', 'product', 'messages.user'])->first();

        $product = $chat->product;

        $user = User::find($id);

        broadcast(new MessageSent($chat, $messageWithRelationships, $product))->toOthers();

        return response()->json(['chat' => $chat, 'message' => $messageWithRelationships], 200);
    }
}
