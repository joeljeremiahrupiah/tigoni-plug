<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;
    public $message;
    public $product;

    /**
     * Create a new event instance.
     */
    public function __construct(Chat $chat, Message $message, Product $product)
    {
        $this->chat = $chat;
        $this->message = $message;
        $this->product = $product;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            // new PrivateChannel('channel-name'),
            new PrivateChannel('user.' . $this->product->user_id),
        ];
    }
}
