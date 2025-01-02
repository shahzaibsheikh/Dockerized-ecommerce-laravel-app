<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductSearching implements ShouldBroadcastNow 
//   ShouldBroadcast , ShouldQueue for instant response pusher using queue
// ShouldBroadcastNow       // for instant response pusher without using queue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $product;
    public string $queue = 'pusher-message-jobs'; // you can identify jobs type using $queue --queue=name
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['message.notification'];
    }

    public function broadcastAs()
    {
        return 'search-product';
    }
}
